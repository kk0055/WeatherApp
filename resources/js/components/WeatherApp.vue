<template>
    <div class="text-white mb-8">
        <div class="places-input text-gray-800">
           <input type="search" id="address" class="form-control" placeholder="Where are we going?" />

<p>Selected: <strong id="address-value">none</strong></p>
        </div>
    <div class="weather-container font-sans rounded-lg w-128 max-w-lg overflow-hidden bg-gray-900 shadow-lg mt-4">
<div class="current-weather flex items-center justify-between px-6 py-8">
    <div class="flex items-center">
   <div>
       <div class="text-6xl font-semi">{{currentTemperature.actual }}
        <small>°C</small>
       </div>

       <!-- <div class="">{{currentTemperature.feels}}</div> -->
   </div>
   <div class="mx-5">
       <!-- <div class="font-semibold">{{ currentTemperature.weather }}</div> -->
       <div class="">{{location.name}}</div>
   </div>
    </div>
  <img :src="currentTemperature.iconUrl" id="wicon">

</div>
<div class="flex justify-end mx-3">
    <h1>{{currentTemperature.feels}} だよ。</h1>
   {{  coldWeather()  }}
  <span class="text-orange-500">{{ vote()  }}</span> 
    <img src="https://pbs.twimg.com/profile_images/1301044744303198213/5fdD8wLG_400x400.jpg" alt="" 
    class=" w-20 max-w-lg  rounded-full ml-2">
    
</div>

<div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden ">
    <div 
     v-for="(day,index) in daily"
     :key="day.index"
     :class="{'mt-8':index > 0}"
     class="flex items-center">
        <div class="w-1/6 text-lg.text-gray-200">{{toDayOfWeek(day.dt)}}</div>
        <div class="w-4/6 px-4 flex items-center">
        <div >{{day.weather[0].description}}</div>
        <div class="ml-3"> Humidity {{day.humidity}}</div> 
       
        </div>
        
          <div class="w-1/6 text-right">
            <div>Max {{Math.round(day.temp.max - 273.15 )}}°C</div> 
            <div>Min {{Math.round(day.temp.min - 273.15 )}}°C</div> 
              <div></div> 
          </div> 
    </div>
</div> <!-- end future-weather -->
    </div>  <!-- end weather-container -->
    </div>
</template>

<script>
    export default {
        mounted() {
             this.fetchData()

            var placesAutocomplete = places({
            appId: 'pl8XL8PV8ZOG',
            apiKey: '97cf7ec02d8e06a00ebc0388b3ca5623',
            container: document.querySelector('#address')
            }).configure({
            type: 'city',
            // type: 'country',
            aroundLatLngViaIP: false,
            });

             var $address = document.querySelector('#address-value')

             placesAutocomplete.on('change', (e) => {
             $address.textContent = e.suggestion.value

            console.log($address.textContent )
             this.location.name = `${e.suggestion.name},${e.suggestion.country}`
             this.location.lat = e.suggestion.latlng.lat
             this.location.lng = e.suggestion.latlng.lng

            });

        placesAutocomplete.on('clear', function() {
            $address.textContent = 'none';
        });
          
        },
        watch: {
        location: {
            handler(newValue,oldValue) {
                this.fetchData()
            },
            deep:true
        }
        },
        data() {
         return {
             currentTemperature: {
                 actual: '',
                 feels: '',
                 summary: '',
                 iconUrl:'',
                 icon:'',
                 weather: '',
                 temp_max: '',
                 humidity: '',
                                 
             },
             msg:'',
             daily:[],
             location: {
                 name: '',
                    lat: 43.6532,
                    lng: -79.38323,
                    api:'6a003d58551a50f0e7670c16009ea9f3',
                 timezone: ''
             }

         }
        },
        methods: {
            fetchData() {
            fetch(`http://api.openweathermap.org/data/2.5/onecall?lat=${this.location.lat}&lon=${this.location.lng}&appid=6a003d58551a50f0e7670c16009ea9f3`)

 
                 

        .then(response => response.json())
        .then(data => {
            console.log(data)

            this.currentTemperature.actual = Math.round(data.current.temp - 273.15 )
            this.currentTemperature.feels =data.current.weather[0].description
            this.currentTemperature.weather =data.current.weather[0].main
            this.location.name =data.timezone
            this.daily = data.daily
            this.location.timezone = data.timezone_offset

            //アイコン
            this.currentTemperature.icon = data.current.weather[0].icon;
            this.currentTemperature.iconUrl = "http://openweathermap.org/img/wn/"+  this.currentTemperature.icon +"@2x.png"

           console.log( this.currentTemperature.iconUrl )

        //当日用データ
       // this.currentTemperature.actual = Math.round(data.main.temp - 273.15 )
                    // this.currentTemperature.temp_max = Math.round(data.main.temp_max - 273.15 )
                    // this.currentTemperature.humidity = data.main.humidity 

                    // this.currentTemperature.icon = data.weather[0].icon

              
            console.log( this.currentTemperature.icon )
        })
    },
    toKebabCase(stringToConvert){
        return stringToConvert.split(' ').join('_')
    },
    toDayOfWeek(timestamp) {
    const newDate = new Date(timestamp*1000)
    const days = ['SUN','MON','TUE','WED','THU','FRI','SAT']

    return days[newDate.getDay()]

    },
    iconUrl() {
      var img = document.getElementById('wicon');  
      var iconCode = data.current.weather[0].icon;
      var icon = '';  
      
      img.setAttribute('src','icon');
      return icon
    },
    coldWeather() {
         if( this.currentTemperature.actual  < 18 && this.location.name.indexOf('America')  === -1 ) {
             this.msg = '寒いよ。固まるよ'
             return this.msg
         }
    },
    vote() {
        if(  this.location.name.indexOf('America')  !== -1) {
            return this.msg = 'VOTE!!';
        }
    }
        }
    }
</script>


