<template>
    <div>
        <button @click="showForm = true" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            registrar cliente
        </button>

        <div class="overflow-x-auto relative mt-10">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                            Documento
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Nombres
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Nacimiento
                        </th>
                        <th scope="col" class="py-3 px-6">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="customer in customers"
                        v-bind:key="customer.id">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ customer.document }}
                        </th>
                        <td class="py-4 px-6">
                            {{ customer.names }}
                        </td>
                        <td class="py-4 px-6">
                            {{ customer.birthday }}
                        </td>
                        <td class="py-4 px-6">
                            eliminawr
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="showForm" class="grid grid-cols-2 gap-5 mt-10">
            <div>
                <label for="">Documento</label>
                <input type="text" v-model="form.document"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div>
                <label for="">Nombres</label>
                <input type="text" v-model="form.names"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div>
                <label for="">Fecha de nacimiento</label>
                <input type="text" v-model="form.birthday"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>


            <button @click="saveCustomer" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                guardar cliente
            </button>
        </div>


    </div>

</template>

<script>
import axios from 'axios'
export default {
    name: "CustomerComponent",

    data() {
        return {
            customers: [],
            showForm: false,
            form: {
                document: '',
                names: '',
                birthday: ''
            }
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

        saveCustomer() {
            axios.post('http://localhost:9000/api/customer', this.form).then(() => {
                this.getCustomers
                location.reload();
            }).catch(err => {
                alert('todo mal')
                console.log(err)
            })
        }
    },

    mounted() {
        this.getCustomers()
        console.log('test')
    }
}
</script>