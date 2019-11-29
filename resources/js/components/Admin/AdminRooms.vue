<template>
    <div>
        <div class="header">
            <h3>Zalen</h3>
            <div class="create-movie">
                <button
                        type="button"
                        class="btn btn-primary"
                        data-toggle="modal"
                        data-target="#new-room-modal"
                >Nieuwe zaal
                    <font-awesome-icon icon="plus"/>
                </button>
            </div>
        </div>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">Naam</th>
                <th scope="col"># Stoelen</th>
                <th scope="col"># Rijen</th>
                <th scope="col">Acties</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="room in rooms">
                <th>{{ room.name }}</th>
                <td>{{ room.seats.length }}</td>
                <td>{{ room.rows.length }}</td>
                <td>
                    <font-awesome-icon
                            icon="pen"
                            data-toggle="modal"
                            data-target="#edit-modal"
                            @click="roomToEdit = room"
                    />
                    <font-awesome-icon
                            icon="trash"
                            data-toggle="modal"
                            data-target="#delete-modal"
                            @click="deleteRoomModal(room)"
                    />
                </td>
            </tr>
            </tbody>
        </table>

        <!--edit room Modal-->
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Verwerk zaal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>
                            Naam
                            <input type="text" v-model="roomToEdit.name">
                        </label>
                        <div class="modal-footer">
                            <button
                                    type="button"
                                    class="btn btn-primary"
                                    @click="editRoom"
                                    data-dismiss="modal"
                            >Voeg toe
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--New room Modal-->
        <div class="modal fade" id="new-room-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nieuwe zaal toevoegen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>
                            Naam
                            <input type="text" v-model="room.name">
                        </label>
                        <label>
                            Aantal rijen
                            <input type="text" v-model="room.rows">
                        </label>
                        <label>
                            Stoelen per rij
                            <input type="text" v-model="room.seatsPerRow">
                        </label>
                        <div class="modal-footer">
                            <button
                                    type="button"
                                    class="btn btn-primary"
                                    @click="NewRoom"
                                    data-dismiss="modal"
                            >Voeg toe
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Room Delete Modal-->
        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ modal.title }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{ modal.description }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="modal.action()">Ja zeker!</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Oh nee toch niet!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "admin-rooms",
        data() {
            return {
                rooms: [],
                modal: {
                    title: "",
                    description: "",
                    action: () => console.log("test")
                },
                room: {},
                roomToEdit: {}
            };
        },
        methods: {
            deleteRoomModal(room) {
                this.modal.title = room.name;
                this.modal.description = `Weet u zeker dat u '${
                    room.name
                    }' wilt verwijderen?`;
                this.modal.action = () =>
                    axios.delete(`../../api/rooms/${room.id}`)
                        .then(() => console.log(`deleted room with id: ${room.id}`))
                        .catch(() => console.log(`oops something went wrong`));
            },
            NewRoom() {
                console.log("test for new room");
                axios.post("../../api/rooms", this.room)
                    .then(() => console.log("created new room: *" + this.room.name))
                    .catch(() => console.log("an error has occurred"));
            },
            editRoom() {
                console.log("test for edit room");
                axios.put("/api/rooms/" + this.roomToEdit.id, this.roomToEdit)
                    .then(() =>
                        console.log("Now the room name is: *" + this.roomToEdit.name)
                    )
                    .catch(() => console.log("an error has occurred"));
            }
        },

        created() {
            axios.get("../../api/rooms")
                .then(res => {
                    this.rooms = res.data;
                    for (let i = 0; i < res.data.length; i++) {
                        let rows = [];
                        for (let i2 = 0; i2 < res.data[i].seats.length; i2++) {
                            if (!rows.includes(res.data[i].seats[i2].row)) {
                                rows.push(res.data[i].seats[i2].row);
                            }
                        }
                        this.rooms[i].rows = rows;
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        }
    };
</script>

<style>
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal {
        color: black !important;
    }

    .modal-body {
        display: flex;
        flex-direction: column;
    }
</style>