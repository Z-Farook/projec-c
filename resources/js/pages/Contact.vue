<template>

<div>
<div class="yellow" align = "center">
<br><br><br> <br>
    <p><b>Email:</b>
    <br />cmi-balie@hr.nl<p>
    <p> <b>Phone:</b>
    <br /> 010 - 794 4000 </p>
    <p> <b>Address:</b>
    <br />Wijnhaven 109
    <br />3011 WN Rotterdam</p>  
</div>

<div class="row yellow">
            <div class="col-sm-6 offset-sm-3">
                <h1>Contact Us</h1>
                <hr>
            <form action="#" method="POST">
                
            <!-- this *@csrf* is token to send mail  -->

                <label for="name">Name</label>
                <input type="text" name="name" class="form-control">
                
                <label for="email" class="mt-3">E-mail</label>
				<input type="email" name="email" class="form-control">

				<label for="message" class="mt-3">Message</label>
				<textarea name="message" cols="300" rows="5" class="form-control"></textarea>
				
                <button type="submit" class="btn btn-success btn-block my-3">Send Email</button>
            <br>
            </form> 
            </div>
	</div>

    <div align = "center">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d19687.367799317846!2d4.
                483976557535974!3d51.91715288242744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c4335dd0ca9255%3A0xd50ba0ff90b595ab!
                2sWijnhaven+109%2C+3011+WN+Rotterdam!5e0!3m2!1snl!2snl!4v1539195316135" 
                width="1200" height="400" frameborder="900" style="border:3" allowfullscreen>
    </iframe>
    </div>

</div>
</template>

<script>
    export default {
        name: "contact"
    }
</script>

<style lang="scss">
.bold {
    font-weight: bold;
}
.yellow {
    color: yellow;
}
</style>