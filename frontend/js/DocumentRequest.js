import { getAllDocuments } from "./fetch.js";


const app = Vue.createApp({
    data() {
        return {
            firstName: '',
            lastName: '',
            middleName: '',
            extension: '',
            email: '',
            document: '',
            purpose: '',
            required_firstname: false,
            required_lastname: false,
            required_email: false,
            required_docu: false,
            required_purpose: false,
            documentTypes: []
        }
    },
    computed: {
        required() {
            this.required_firstname = (this.firstName.trim() === '') ? true : false;
            this.required_lastname = (this.lastName.trim() === '') ? true : false;
            this.required_email = (this.email.trim() === '') ? true : false;
            this.required_purpose = (this.purpose.trim() === '') ? true : false;
        }
    },
    methods: {
        
    },
    mounted() {
        getAllDocuments().then((data) => {
            this.documentTypes = data;
        });
    }
});
app.mount("#app");