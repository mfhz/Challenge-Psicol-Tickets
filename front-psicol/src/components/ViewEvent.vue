<template>
    <div class="grid grid-cols-8 gap-5">
        <div class="rounded-lg cursor-pointer" @click="registerChair(chair)"
            :class="{'bg-gray-400' : getDisabledChair(chair), 'bg-blue-400' : !getDisabledChair(chair)}"
            v-for="chair in event.available_tickets" v-bind:key="chair">
            {{ chair }}
        </div>
    </div>


    <div class="mt-10 grid grid-cols-4 gap-5 mx-12" v-if="showForm">
        <div>
            <label for="">Evento</label>
            <input type="text" v-model="form.event_id" disabled
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>
        <div>
            <label for="">Silla</label>
            <input type="text" v-model="form.chair" disabled
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>
        <div>
            <label for="">Cliente</label>
            <select v-model="form.customer_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option v-for="customer in customers" v-bind:key="customer.id" :value="customer.id">{{ customer.names }}</option>
            </select>
        </div>

        <button @click="saveTicket(form)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Registrar ticket
        </button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['id'],

    data() {
        return {
            event: {},
            customers: [],
            form: {
                customer_id: '',
                event_id: '',
                chair: ''
            },
            showForm: false
        }
    },

    methods: {
        getCustomers() {
            axios.get('http://localhost:9000/api/customer').then(resp => {
                this.customers = resp.data
            }).catch(err => {
                alert('todo mal')
                console.log(err)
            })
        },

        getEvent() {
            axios.get('http://localhost:9000/api/event/' + this.id).then(resp => {
                this.event = resp.data
            }).catch(err => {
                console.log(err)
            })
        },

        getDisabledChair(chair) {
            let disabledChair = this.event.sell_chairs.find(element => element === chair)
            return disabledChair !== undefined
        },

        registerChair(chair){
            this.showForm = true
            this.form = {
                customer_id: '',
                event_id: this.id,
                chair: chair
            }
        },

        resetForm(){
            this.showForm = false
            this.form = {
                customer_id: '',
                event_id: '',
                chair: ''
            }
        },

        saveTicket(data){
            axios.post('http://localhost:9000/api/ticket', data).then(() => {
                this.getEvent()
                this.resetForm()
            }).catch(err => {
                alert('todo mal')
                console.log(err)
            })
        }
    },

    mounted() {
        this.getEvent()
        this.getCustomers()
    }
}
</script>
