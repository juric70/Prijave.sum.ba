<script setup>
const props = defineProps(['pila']);
</script>

<template>

    <table id="tijelo1">
        <thead class="ajmo">
            <tr>
            <th class="pisa" id="mora">Pitanja</th>
            <th class="pisa" id="dola">Odogovori</th>
            </tr>
        </thead>
<tr v-for="item in pila" :key="item.pitanja" class="miron">
<td id="ala"><b>{{ item.pitanja}}</b></td>
<td id="mala"><b>{{ item.odgovor }}</b></td>
</tr>
    </table>
</template>
<style>
.pisa{
    color:#094776;
}
#mora{
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    padding-left: 3rem;
    border-bottom: 3px solid #094776;
    border-top:  3px solid #094776;
    border-left:  3px solid #094776;

}
#dola{
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    text-align: center;
    border-bottom: 3px solid #094776;
    border-top:  3px solid #094776;
    border-right:  3px solid #094776;
}
.ajmo{
    width: 100%;
    height: 5vh;
    border-radius: 25px;
    border: 5px solid #094776;
    background-color:#094776 ;
    border-collapse: collapse;
    border-spacing: 0;
    background-color: white;
}
#tijelo1{
    width: 100%;
    height: auto;
    table-layout: fixed;
    overflow: scroll;
    border-collapse:separate; 
    border-spacing:0px 20px;
}
#ala{
    border-bottom: 3px solid #094776;
    border-top:  3px solid #094776;
    border-left:  3px solid #094776;
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    height: 3rem;
    overflow: auto;
    text-align: center;
    border-spacing: 0;
    color:#094776;
    font-size: 15px;
}
#mala{
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    border-bottom: 3px solid #094776;
    border-top:  3px solid #094776;
    border-right:  3px solid #094776;
    height: 3rem;
    margin-top: 60px;
    text-align: center;
    border-spacing: 0;
    overflow:auto;
    font-size: 1rem;
    color:black;
    white-space: pre-wrap;
}
.miron {
    width: 100%;
    height: 50px;
    overflow: auto;
    background-color: white;
}

</style>