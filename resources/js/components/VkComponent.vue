<template>
<div class="container">
<div class="row">
  <div class="col-3">
    <div class="group-description">
      <img :src="this.mainImage" alt="" class="full-pic">
      <div class="description-block">
        <p>
          <b>Группа: </b>{{nameGropVk}}<br>
          <b>Подписчиков: </b>{{group_count}}<br>
        </p>
      </div>
    </div>
    <div class="source">
      <button class="btn contacts">ссылки</button>
      <button class="btn contacts">контакты</button>
    </div>
  </div>

  <div class="col-9">
    <div class="audience">
      <input v-model="group_id" type="text" class="search" placeholder="Введите ID группы">
      <button @click="get_group_states" class="search-btn" type="button" name="button">Поиск</button>
    </div>

    <div class="main-info">
        <div class="audience-info">
          <bar-chart :chart-data='bar' :height="400"  :options='{responsive: true, maintainAspectRatio: false,legend: {display: false}, }'></bar-chart>
        </div>
    </div>

    <div class="group-activity">
      <pie-chart :chart-data='grop' :height="100" :options='{responsive: true, maintainAspectRatio:true, legend: {display: false}, }' ></pie-chart>
    </div>

    <a href="#">
      <div class="us">
        <h3>О нас</h3>
      </div>
    </a>
  </div>
</div>
</div>
</template>

<script>
    import PieChart from './PieChart.js'
    import BarChart from './BarChart.js'

    export default {
      components:{
        PieChart,
        BarChart,
      },
      data(){
        return {
          mainImage:'',
          sex:[],
          city:[],
          object_id:'',
          nameGropVk:'',
          grop:{
          labels:['женский','мужской'],
          datasets:[
            {
              lable:'sexx',
              backgroundColor:['#ff6384','#36a2eb'],
              data: [],
            }
          ]},

          bar:{
            labels:['Москва','Санкт-Петербург','Другие'],
            datasets:[
              {
              lable:'city',

              backgroundColor: ['#f87979','#f87979','#f87979'],
              data:[],
            }
          ]
          },

          group_id:'',
          group_states:[],
          sex_states:[],
          group_count:1,
          vk_offset:0,
          allCity:[],


        }
      },
        mounted() {
        },
        methods: {
          async get_group_states(){


          await $.ajax({
              url:'https://api.vk.com/method/groups.getMembers?group_id='+this.group_id+'&fields=sex&sort=id_desc&count=1000&access_token=c7e831a47850a201c821663da52d2db54ec67cd0ebacc08dcca03bca4759274302312953c25ff2fd53124&v=5.126',
              method:"GET",
              dataType:'JSONP',
              success: res => {
                        this.group_count = res.response.count;

                    },
              error: err => console.log(err),
            });

            this.sex_states = [];
            this.vk_offset = 0;
            this.allCity = [];
            for (let i=0; 4 > i; i++ ) {

              await $.ajax({
                url:'https://api.vk.com/method/groups.getMembers?group_id='+this.group_id+'&offset='+this.vk_offset+'&fields=sex&sort=id_desc&count=1000&access_token=c7e831a47850a201c821663da52d2db54ec67cd0ebacc08dcca03bca4759274302312953c25ff2fd53124&v=5.126',
                method:"GET",
                dataType:'JSONP',
                success: res => {
                          let all_sex = [];
                          res.response.items.forEach(function(elem){
                            all_sex.push(Object.assign(elem.sex));
                          });
                          this.sex_states.push(all_sex);

                      },
                error: err => console.log(err),
              });

              await $.ajax({
                url:'https://api.vk.com/method/groups.getMembers?group_id='+this.group_id+'&offset='+this.vk_offset+'&fields=city&sort=id_desc&count=1000&access_token=c7e831a47850a201c821663da52d2db54ec67cd0ebacc08dcca03bca4759274302312953c25ff2fd53124&v=5.126',
                method:"GET",
                dataType:'JSONP',
                success: res => {
                          let all_city = [];
                          res.response.items.forEach(function(elem){
                            if (elem.city) {
                              all_city.push(Object.assign(elem.city));
                            }else {
                            }

                          });

                          this.allCity.push(all_city);

                      },
                error: err => console.log(err),
              });


              this.vk_offset = this.vk_offset + 1000;
            };
            let new_sex_states = [...this.sex_states[0],...this.sex_states[1],...this.sex_states[2],...this.sex_states[3]];
            let new_city_states = [...this.allCity[0],...this.allCity[1],...this.allCity[2],...this.allCity[3]];
            this.sex_states = new_sex_states;
            this.allCity = new_city_states;
            this.sex_count(this.sex_states);
            this.getCity(this.allCity);
            setTimeout(this.getMainImage, 5000,this.group_id);

          },

          sex_count(allSex){
            this.sex=[];
            let man=0;
            let woman=0;
            allSex.forEach(function(elem){
              if (elem == 2) {
                man++
              }else {
                woman++
              }
            });
            this.sex.push(woman);
            this.sex.push(man);


            // this.grop.datasets[0].data[0] = woman;
            // this.grop.datasets[0].data[1] = man;
            this.grop ={
              labels:['женский','мужской'],
              datasets:[
                {
                  lable:'sexx',
                  backgroundColor:['#ff6384','#36a2eb'],
                  data: this.sex,
                }
              ]
            }


          },
          getCity(allCity){
            this.city=[];
            let spb = 0;
            let mos = 0;
            let another = 0;
            allCity.forEach(function(elem){

              if (elem.title == 'Москва') {
                mos++
              }else if(elem.title == 'Санкт-Петербург') {
                spb++
              }else{
                another++
              }
            });
            this.city.push(mos);
            this.city.push(spb);
            this.city.push(another);
            this.bar = {
              labels:['Москва','Санкт-Петербург','Другие'],
              datasets:[
                {
                lable:'sexx',

                backgroundColor: '#ff7a96',
                data:this.city,
              }
            ]
            }

          },
          async getGroupId(groupName){

            await $.ajax({
              url:'https://api.vk.com/method/utils.resolveScreenName?screen_name='+ groupName +'&access_token=c7e831a47850a201c821663da52d2db54ec67cd0ebacc08dcca03bca4759274302312953c25ff2fd53124&v=5.126',
              method:"GET",
              dataType:'JSONP',
              success: res => {
                 this.object_id =  res.response.object_id;
              },
              error: err => console.log(err),
            });

          },

          async getMainImage(idGroup){

            await this.getGroupId(idGroup)
            let iddd = this.object_id;

            await $.ajax({
              url:'https://api.vk.com/method/photos.get?owner_id=-' + iddd + '&album_id=profile&count=1&rev=1&photo_sizes=1&access_token=c7e831a47850a201c821663da52d2db54ec67cd0ebacc08dcca03bca4759274302312953c25ff2fd53124&v=5.126',
              method:"GET",
              dataType:'JSONP',
              success: res => {
                this.mainImage = res.response.items[0].sizes[res.response.items[0].sizes.length-3].url;
              },
              error: err => console.log(err),
            });

            await $.ajax({
              url:'https://api.vk.com/method/groups.getById?group_ids='+this.group_id+'&access_token=c7e831a47850a201c821663da52d2db54ec67cd0ebacc08dcca03bca4759274302312953c25ff2fd53124&v=5.126',
              method:"GET",
              dataType:'JSONP',
              success: res => {
                this.nameGropVk = res.response[0].name;
              },
              error: err => console.log(err),
            });

          },

          },


    }
</script>
