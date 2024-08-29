<script>
import axios from 'axios';
axios.defaults.withCredentials = true;

export default{
    mounted(){
        this.odjavi();
    },
    methods: {
        odjavi(){
            try {
                axios.post("http://localhost:8000/logout", {
                }).then(res => {
                navigateTo('/');
            });
        }catch(error){console.log(error);}
    }
}
}

</script>