<template>
    <div>
        <button @click="showForm = true" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Registrar Evento
        </button>

        <div class="overflow-x-auto relative mt-10">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                            Nombre
                        </th>
                        <th scope="col" class="py-3 px-6">
                           Fecha
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Tickets disponibles
                        </th>
                        <th scope="col" class="py-3 px-6">
                            
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="event in events"
                        v-bind:key="event.id">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ event.name }}
                        </th>
                        <td class="py-4 px-6">
                            {{ event.date }}
                        </td>
                        <td class="py-4 px-6">
                            {{ event.available }} / {{ event.available_tickets }} 
                        </td>
                        <td class="py-4 px-6">
                            <router-link :to="'/events/' + event.id" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"> VER EVENTO</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="showForm" class="grid grid-cols-2 gap-5 mt-10">
            <div>
                <label for="">Nombre</label>
                <input type="text" v-model="form.name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div>
                <label for="">Tickets a la venta</label>
                <input type="text" v-model="form.available_tickets"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div>
                <label for="">Fecha de evento</label>
                <input type="text" v-model="form.date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>


            <button @click="saveEvent" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                guardar Evento
            </button>
        </div>


    </div>

</template>

<script>
import axios from 'axios'
export default {
    name: "EventComponent",

    data() {
        return {
            events: [],
            showForm: false,
            form: {
                name: '',
                available_tickets: '',
                date: ''
            }
        }
    },

    methods: {
        getEvent() {
            axios.get('http://localhost:9000/api/event').then(resp => {
                this.events = resp.data
            }).catch(err => {
                alert('todo mal')
                console.log(err)
            })
        },

        saveEvent() {
            axios.post('http://localhost:9000/api/event', this.form).then(() => {
                this.getEvent
                location.reload();
            }).catch(err => {
                alert('todo mal')
                console.log(err)
            })
        }
    },

    mounted() {
        this.getEvent()
        console.log('test')
    }
}
</script>