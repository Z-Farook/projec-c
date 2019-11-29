<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Quotation;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class OrderController extends Controller
{
    public function createPayment(){
        if(isset($_GET['title']) && isset($_GET['amount']) && isset($_GET['email']) && isset($_GET['seats']) && isset($_GET['snacks'])){
            $title = $_GET['title'];
            $amount = $_GET['amount'];
            $snacks = $_GET['snacks'];
            $email = $_GET['email'];
            $seats = $_GET['seats'];

            $snacks = array_chunk(explode(",",$snacks),2);
            // return $snacks[0][1];
            //return $snacks;

            //testing
            // $title = '1';
            // $amount = '20.00';
            // $email = '0948935@hr.nl';
            // $seats = [5,6];
            // $snacks = [],["1",2,"Cola",1],["2",2,"Red Bull Simply Cola",2],["3",3,"Popcorn",3],[0,2,"Kit Kat",4];
            // $snacks = array_values(array_filter($snacks));

            // $tempArray = [];

            // for($i = 0; $i < count($snacks); $i++){
            //     if(!empty($snacks[$i])){
                    //array_push($tempArray, $snacks[$i]);
                    //return $snacks[1];
            //     }
            // }

            // return $tempArray[1];

            // $snacks = $tempArray;
            $orderId = time().'-'.mt_rand();
            
            $mollie = new \Mollie\Api\MollieApiClient();
            $mollie->setApiKey("test_MybdHCWjV8eWgypEgvH63HsCpqSx9F");

            $payment = $mollie->payments->create([
                "amount" => [
                    "currency" => "EUR",
                    "value" => $amount
                ],
                "description" => "Betalingkenmerk: {$orderId}",
                "redirectUrl" => "http://127.0.0.1:8000/order?id={$orderId}",
                "webhookUrl"  => "https://www.google.nl",
                "locale"      => "nl_NL",
                "method"      => "ideal",
            ]);
            
            $this->savePayment($orderId, $amount);
            $this->reserveSeats($seats, $title, $this->getReservationIdByReference($orderId)[0]);
            $this->reserveSnacks($this->getReservationIdByReference($orderId)[0], $snacks);
            $this->sendReceipt($orderId, $email, $amount);
            return [$payment->getCheckoutUrl()];
       }
    }

    public function getPaymentStatus(){
        if(isset($_GET['reference']) ){
            $reference = $_GET['reference'];
            $result = DB::table('reservations')
                    ->join('states', 'reservations.state_id', '=', 'states.id')
                    ->select('reservations.id','states.title', 'reservations.total')
                    ->where('reference', '=', $reference)
                    ->get();
            return $result;
        }
    }

    public function getPaymentHistory(){
        $userId = Auth::id();
        if($userId !== null){
            $result = DB::table('reservations')
                ->select('reference', 'total', 'created_at')
                ->where('user_id', '=', $userId)
                ->get();
            return $result;
        }
    }

    public function getSeats(){
        if(isset($_GET['room_id']) ){
            $roomId = $_GET['room_id'];
            $result = DB::table('seats')
                        ->join('rooms', 'rooms.id', '=', 'seats.room_id')
                        ->select('seats.id', 'seats.number', 'seats.row')
                        ->where('room_id', '=', $roomId)
                        ->get();
            return $result;
        }
    }

    public function getReservedSeats(){
        if(isset($_GET['show']) ){
            $show = $_GET['show'];
            $result = DB::table('seats__reserveds')
                ->select('seat_id')
                ->where('show_id', '=', $show)
                ->pluck('seat_id');
            return $result;
        }
    }

    public function getReservedSeatsByReservationId(){
        if(isset($_GET['reservation']) ){
            $reservation = $_GET['reservation'];
            //$reservation = '89';
            $seats = DB::table('seats__reserveds')
                ->select('seat_id')
                ->where('reservation_id', '=', $reservation)
                ->pluck('seat_id');
            $show = DB::table('seats__reserveds')
                ->select('show_id')
                ->where('reservation_id', '=', $reservation)
                ->limit(1)
                ->pluck('show_id');
            
            $tempArray = [];
            foreach($seats as $seat){
                $result = DB::table('seats')
                    ->select('id', 'number', 'row')
                    ->where('id', '=', $seat)
                    ->get();
                array_push($tempArray, $result);
            }
            array_push($tempArray, [$show,'Zaal 1']);
            return $tempArray;
        }
    }

    public function getFoodByReservationId(){
        if(isset($_GET['reservation']) ){
            $reservation = $_GET['reservation'];
            $food = DB::table('reservations__foods')
                ->join('foods', 'foods.id', '=', 'reservations__foods.food_id')
                ->select('foods.product_name', 'reservations__foods.amount')
                ->where('reservation_id', '=', $reservation)
                ->get();
            return $food;
        }
    }

    public function isLoggedIn(){
        return Auth::id();
    }

    private function getReservationIdByReference($reference){
        $result = DB::table('reservations')
            ->select('id')
            ->where('reference', '=', $reference)
            ->pluck('id');
        return $result;
    }

    private function reserveSeats($seats, $show, $reservation){
        foreach($seats as $key){
            DB::insert('insert into seats__reserveds (seat_id, show_id, reservation_id, created_at, updated_at) values (?, ?, ?, ?, ?)', 
            [$key, $show, $reservation, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
        }
    }
    //////////////////////////////////////
    private function reserveSnacks($reservation, $snacks){
        foreach($snacks as $snack){
            if((int)$snack[0] > 0){
                DB::insert('insert into reservations__foods (reservation_id, food_id, amount,  created_at, updated_at) values (?, ?, ?, ?, ?)', 
                [$reservation, (int)$snack[1], (int)$snack[0], date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
            }
        }
    }

    private function savePayment($reference, $total){
        DB::insert('insert into reservations (reference, user_id, state_id, total, created_at, updated_at) values (?, ?, ?, ?, ?, ?)', 
        [$reference, Auth::id(), 2, $total, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
    }

    private function sendReceipt($orderId, $email, $amount){
        $mail = new PHPMailer(true);                              
        try {
            $mail->isSMTP();                                      
            $mail->Host = 'smtp.gmail.com';                       
            $mail->SMTPAuth = true;                               
            $mail->Username = 'bioscoopvue@gmail.com';            
            $mail->Password = 'K)#S&D23H#';                       
            $mail->SMTPSecure = 'ssl';                            
            $mail->Port = 465;                                    

            $mail->setFrom('bioscoopvue@gmail.com');
            $mail->addAddress($email);                            

            $mail->isHTML(true);                                  
            $mail->Subject = "Betreft factuur: {$orderId}";
            $mail->Body    = "Geachte klant, <br><br> Het totaalbedrag is <b>{$amount}</b> euro. U kunt uw ticket terugvinden via <a href='http://127.0.0.1:8000/order?id={$orderId}'>deze</a> link. <br><br> Met vriendelijke groeten, <br><br> Bioscoop Vue";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }
}
