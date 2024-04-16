<template>
  <h2>Dashboard</h2>
  <div class="grid-container my-4">
      <div class="animated slideInDown">
        <div class="dash-widget card">
          <div class="dash-widgetimg"><span style=""><i class="fas fa-money-check-alt mr-2" b-1fr6g0feah=""></i></span>
          </div>
          <div class="dash-widgetcontent mx-3">
            <h5><span class="counters">PKR 82,505.65</span></h5>
            <h6>Total Receivables</h6>
          </div>
        </div>
      </div>
      <div class="animated slideInDown">
        <div class="dash-widget card">
          <div class="dash-widgetimg"><span style="background-color: #E5F8ED;"><i class="fas fa-money-check-alt mr-2"
                b-1fr6g0feah=""></i></span></div>
          <div class="dash-widgetcontent mx-3">
            <h5><span class="counters">PKR -148,619.20</span></h5>
            <h6>Total Payables</h6>
          </div>
        </div>
      </div>
      <div class="animated slideInDown">
        <div class="dash-widget card">
          <div class="dash-widgetimg"><span><i class="fas fa-hand-holding-usd mr-2" b-1fr6g0feah=""></i></span></div>
          <div class="dash-widgetcontent mx-3">
            <h5><span class="counters">PKR 20,852.50</span></h5>
            <h6>Cash In Hand</h6>
          </div>
        </div>
      </div>
      <div class="animated slideInDown">
        <div class="dash-widget card">
          <div class="dash-widgetimg"><span><i class="fas fa-stream"></i></span></div>
          <div class="dash-widgetcontent mx-3">
            <h5><span class="counters">PKR 36,455.69</span></h5>
            <h6>Total Income</h6>
          </div>
        </div>
      </div>

    <div class="animated slideInUp">
      <div class="dash-widget card">
        <div class="dash-widgetimg"><span><i class="fas fa-comment-dollar"></i></span></div>
        <div class="dash-widgetcontent mx-3">
          <h5><span class="counters">PKR 33,300.00</span></h5>
          <h6>Total Expenses</h6>
        </div>
      </div>
    </div>
    <div class="animated slideInUp">
      <div class="dash-widget card">
        <div class="dash-widgetimg"><span style="background-color: #E5F8ED;"><i class="fas fa-receipt"></i></span></div>
        <div class="dash-widgetcontent mx-3">
          <h5><span class="counters">4</span></h5>
          <h6>Open Quotations</h6>
        </div>
      </div>
    </div>
    <div class="animated slideInUp">
      <div class="dash-widget card">
        <div class="dash-widgetimg"><span><i class="far fa-calendar-alt"></i></span></div>
        <div class="dash-widgetcontent mx-3">
          <h5><span class="counters">3</span></h5>
          <h6>Open Purchase orders</h6>
        </div>
      </div>
    </div>
  </div>

  <div class="card main-card">
    <div class="idea">
      <img src="../../assets/img/3.webp" alt="" class="animated slideInLeft">
      <div>
        <p class="animated slideInRight">
          <i class="fa-solid fa-quote-left"></i>
           Many of life's failures are people who did not realize how close they were to success when they gave up. 
           <i class="fa-solid fa-quote-right"></i>
        </p>   
      </div>
    </div>
  </div>
</template>

<script>
// import axios from 'axios';


export default {
  name: 'DashBoard',
}
</script>

<style scoped>
h2 {
  font-weight: 700;
  color: #9D568A;
}
.grid-container {
  display: grid;
  grid-template-columns: auto auto auto auto;
  gap: 20px;
}
@media (max-width: 1265px){
  .grid-container {
  grid-template-columns: auto auto auto;
  }
}
@media (max-width: 800px){
  .grid-container {
  grid-template-columns: auto auto;
  }
}
@media (max-width: 575px){
  .grid-container {
  grid-template-columns: auto;
  }
}

.dash-widgetimg span {
  border-radius: 50%;
  background-color: #FEEDED;
  padding: 15px 17px;
}

.dash-widget {
  display: flex;
  flex-direction: row;
  align-items: center;
  /* border: none; */
  border-color: bisque;
  padding: 20px 10px;
  /* margin: 0 0 25px; */
}

.counters {
  font-size: 18px;
  font-weight: bold;
}

.dash-widgetcontent h6 {
  font-size: 14px;
}

.main-card {
  border: none;
}
.idea {
  border:1px solid wheat;
  padding: 15px;
  border-radius: 7px;
  display: flex;
  align-items: center;
}
.idea img {
  width: 30%;
  border-radius: 5px;
  border-top-right-radius: 50px;
  border-bottom-left-radius: 50px;
}
.idea p {
  padding: 15px;
  font-size: 20px;
  /* animation:opacity 2s linear infinite alternate; */
}

/* @keyframes opacity {
  0% {
    transform:scale(.95);
    color: blue;
    opacity: .5;
  }
  100% {
    transform:scale(1);
    color: #9D568A;
    opacity: 1;
  }
} */



.animated {
  animation-duration: 1s;
  animation-fill-mode: both;
}

@keyframes slideInDown {
  from {
    transform: translate3d(0, -100%, 0);
    visibility: visible;
  }

  to {
    transform: translate3d(0, 0, 0);
  }
}

.slideInDown {
  animation-name: slideInDown;
}

@keyframes slideInLeft {
  from {
    transform: translate3d(-100%, 0, 0);
    visibility: visible;
  }

  to {
    transform: translate3d(0, 0, 0);
  }
}

.slideInLeft {
  animation-name: slideInLeft;
}

@keyframes slideInRight {
  from {
    transform: translate3d(100%, 0, 0);
    visibility: visible;
  }

  to {
    transform: translate3d(0, 0, 0);
  }
}

.slideInRight {
  animation-name: slideInRight;
}

@keyframes slideInUp {
  from {
    transform: translate3d(0, 100%, 0);
    visibility: visible;
  }

  to {
    transform: translate3d(0, 0, 0);
  }
}
.slideInUp {
  animation-name: slideInUp;
}
</style>