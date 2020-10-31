<template>
    <div class="text-white mb-8">
        <div class="places-input text-gray-800">
            <input type="text" class="w-full" name="" id="">
        </div>
    <div class="weather-container font-sans rounded-lg w-128 max-w-lg overflow-hidden bg-gray-900 shadow-lg mt-4">
<div class="current-weather flex items-center justify-between px-6 py-8">
    <div class="flex items-center">
   <div>
       <div class="text-6xl font-semi">{{currentTemperature.actual }}
        <small>°C</small>
       </div>

       <div class="">{{currentTemperature.feels}}</div>
   </div>
   <div class="mx-5">
       <div class="font-semibold">{{ currentTemperature.weather }}</div>
       <div class="">{{location.name}}</div>
   </div>
    </div>
 <canvas id="iconCurrent" ref="iconCurrent" width="128" height="128"></canvas>
  
</div>
<div class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden">
    <div 
     v-for="(day,index) in daily"
     :key="day.index"
     :class="{'mt-8':index > 0}"
     v-if="index < 5"
     class="flex items-center">
        <div class="w-1/6 text-lg.text-gray-200">{{toDayOfWeek(day.dt)}}</div>
        <div class="w-4/6 px-4 flex items-center">
        <div>Humidity {{day.humidity}}</div> 
        <div class="ml-3">{{day.weather[0].description}}</div>
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
        },
        data() {
         return {
             currentTemperature: {
                 actual: '',
                 feels: '',
                 summary: '',
                 icon: '',
                 weather: '',
                 temp_max: '',
                 humidity: '',
                 
             },
             daily:[],
             location: {
                 name: '',
                 lat:43.6532,
                 lng: -79.38323,
                 timezone: ''
             }
         }
        },
        methods: {
            fetchData() {
                var skycons = new Skycons({"color": "pink"});
                fetch('/api/weather')
                //   fetch(`/api/weather?lat=${this.location.lat}?lng=${this.location.lng}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data)


                 
                    this.currentTemperature.actual = Math.round(data.current.temp - 273.15 )
                    this.currentTemperature.feels =data.current.weather[0].description
                    this.currentTemperature.weather =data.current.weather[0].main
                    this.location.name =data.timezone
                    this.currentTemperature.icon = this.toKebabCase(data.current.weather[0].description)
                    this.daily = data.daily
                    this.location.timezone = data.timezone_offset

    //当日用データ
   // this.currentTemperature.actual = Math.round(data.main.temp - 273.15 )
                    // this.currentTemperature.temp_max = Math.round(data.main.temp_max - 273.15 )
                    // this.currentTemperature.humidity = data.main.humidity 

                    // this.currentTemperature.icon = data.weather[0].icon

                    //forのデータ
                    // this.currentTemperature.loop = data.main.temp
                 
                    skycons.add("iconCurrent", )
                    skycons.play()
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

            //{{ toDayOfWeek()  }}
            },
        }
    }
</script>


