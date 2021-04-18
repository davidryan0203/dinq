<template>
	<div class="container">
    	<div class="row justify-content-center">
			<div class="col-xxl-3 col-lg-3">
	            <div class="card bg-primary text-white mb-4">
	                <div class="card-body">
	                    <div class="d-flex justify-content-between align-items-center">
	                        <div class="mr-3">
	                            <div class="text-white-75 small"><span v-if="user.user_type == '2'">Total Spend</span><span v-else>Total Redeemed Amount</span></div>
	                            <div class="text-lg font-weight-bold">{{paidRedeemed}}</div>
	                        </div>
	                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign feather-xl text-white-50"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
	                    </div>
	                </div>
	                <div class="card-footer d-flex align-items-center justify-content-between">
	                    <a class="small text-white stretched-link" href="#">View Report</a>
	                    <div class="small text-white"><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
	                </div>
	            </div>
	        </div>

	        <div class="col-xxl-3 col-lg-3">
	            <div class="card bg-primary text-white mb-4">
	                <div class="card-body">
	                    <div class="d-flex justify-content-between align-items-center">
	                        <div class="mr-3">
	                            <div class="text-white-75 small"><span v-if="user.user_type == '2'">Total Spend</span><span v-else>Total Revenue</span></div>
	                            <div class="text-lg font-weight-bold">{{revenue}}</div>
	                        </div>
	                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign feather-xl text-white-50"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
	                    </div>
	                </div>
	                <div class="card-footer d-flex align-items-center justify-content-between">
	                    <a class="small text-white stretched-link" href="#">View Report</a>
	                    <div class="small text-white"><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
	                </div>
	            </div>
	        </div>

	        <div class="col-xxl-3 col-lg-3">
	            <div class="card bg-success text-white mb-4">
	                <div class="card-body">
	                    <div class="d-flex justify-content-between align-items-center">
	                        <div class="mr-3">
	                            <div class="text-white-75 small">Total Redeemed Order Count</div>
	                            <div class="text-lg font-weight-bold">{{redeemed}}</div>
	                        </div>
	                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square feather-xl text-white-50"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
	                    </div>
	                </div>
	                <div class="card-footer d-flex align-items-center justify-content-between">
	                    <a class="small text-white stretched-link" href="#">View Report</a>
	                    <div class="small text-white"><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
	                </div>
	            </div>
	        </div>

	        <div class="col-xxl-3 col-lg-3">
	            <div class="card bg-danger text-white mb-4">
	                <div class="card-body">
	                    <div class="d-flex justify-content-between align-items-center">
	                        <div class="mr-3">
	                            <div class="text-white-75 small">Pending Orders</div>
	                            <div class="text-lg font-weight-bold">{{pendingOrders}}</div>
	                        </div>
	                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle feather-xl text-white-50"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
	                    </div>
	                </div>
	                <div class="card-footer d-flex align-items-center justify-content-between">
	                    <a class="small text-white stretched-link" href="#">View Reports</a>
	                    <div class="small text-white"><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
	                </div>
	            </div>
	        </div>

	        <div v-show="user.user_type == '1' || user.user_type == '0'" class="col-xxl-3 col-lg-3">
	            <div class="card bg-warning text-white mb-4">
	                <div class="card-body">
	                    <div class="d-flex justify-content-between align-items-center">
	                        <div class="mr-3">
	                            <div class="text-white-75 small">Todays Checkin</div>
	                            <div class="text-lg font-weight-bold">{{todaysCheckins}}</div>
	                        </div>
	                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar feather-xl text-white-50"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
	                    </div>
	                </div>
	                <div class="card-footer d-flex align-items-center justify-content-between">
	                    <a class="small text-white stretched-link" href="#">View Report</a>
	                    <div class="small text-white"><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
	                </div>
	            </div>
	        </div>

	        <!-- <div class="col-xl-6 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header">
                        Earnings Breakdown
                        <div class="dropdown no-caret">
                            <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="areaChartDropdownExample" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical text-gray-500"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button>
                            <div class="dropdown-menu dropdown-menu-right animated--fade-in-up" aria-labelledby="areaChartDropdownExample">
                                <a class="dropdown-item" href="#!">Last 12 Months</a>
                                <a class="dropdown-item" href="#!">Last 30 Days</a>
                                <a class="dropdown-item" href="#!">Last 7 Days</a>
                                <a class="dropdown-item" href="#!">This Month</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#!">Custom Range</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       <div class="chart-area"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div><canvas id="myAreaChart" width="433" height="240" style="display: block; width: 433px; height: 240px;" class="chartjs-render-monitor"></canvas></div> 
                        <line-chart :chart-data="datacollection"></line-chart>
   						<button @click="fillData()">Randomize</button>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header">
                        Monthly Revenue
                        <div class="dropdown no-caret">
                            <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="areaChartDropdownExample" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical text-gray-500"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button>
                            <div class="dropdown-menu dropdown-menu-right animated--fade-in-up" aria-labelledby="areaChartDropdownExample">
                                <a class="dropdown-item" href="#!">Last 12 Months</a>
                                <a class="dropdown-item" href="#!">Last 30 Days</a>
                                <a class="dropdown-item" href="#!">Last 7 Days</a>
                                <a class="dropdown-item" href="#!">This Month</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#!">Custom Range</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <line-chart :chart-data="datacollection"></line-chart>
   						<button @click="fillData()">Randomize</button>
                    </div>
                </div>
            </div> -->
	    </div>
	</div>
</template>

<script type="text/javascript">
	export default{
		components: {
    	},
		data(){
			return{
				datacollection: null,
				revenue: 0,
				redeemed : 0,
				paidRedeemed : 0,
				pendingOrders : 0,
				todaysCheckins : 0,
				currencyCodes: {},
				user: {}
			}
		},
		mounted(){
			this.fillData()
			this.getRevenue()
			this.getRedeemed()
			this.getPendingOrders()
			this.getRedeemedOrders()
			this.getTotalRedeemed()
			//this.getCurrency()

			axios.get('/get-user-details').then((response) => {
				this.user = response.data
			})
		},
		methods:{
			getCurrency(){
				axios.get('/get-user-details').then((response) => {
					// this.user = response.data
					// // if(this.user.user_type == 1){
					// // 	this.currencyCodes = this.user.venue
					// // }

					// if(this.user.user_type == 0){
					// 	//this.currencyCodes = this.user.venue
					// }

					// if(this.user.user_type == 2){
					// 	this.currencyCodes = this.user.supplier
					// 	axios.get('/get-supplier-venues').then((response) => {
					// 		console.log(response.data)
					// 		this.venues = response.data
					// 	})
					// }
					// console.log(this.currencyCodes)
				})
			},
	      	fillData () {
		        this.datacollection = {
		          	labels: [this.getRandomInt(), this.getRandomInt()],
		          	datasets: [
			            {
			              	label: 'Data One',
			              	backgroundColor: '#f87979',
			              	data: [this.getRandomInt(), this.getRandomInt()]
			            }, {
			              	label: 'Data Two',
			              	backgroundColor: '#f87979',
			              	data: [this.getRandomInt(), this.getRandomInt()]
			            }, {
			              	label: 'Data Three',
			              	backgroundColor: '#f87979',
			              	data: [this.getRandomInt(), this.getRandomInt()]
			            }
		          	]
		        }
	      	},
	      	getRandomInt () {
	        	return Math.floor(Math.random() * (50 - 5 + 1)) + 5
	      	},
	      	getRevenue(){
	      		axios.get('/get-revenue').then((response) => {
	      			this.revenue = response.data
	      		})
	      	},
	      	getTotalRedeemed(){
	      		axios.get('/get-paid-redeemed').then((response) => {
	      			this.paidRedeemed = response.data
	      		})
	      	},
	      	getRedeemed(){
	      		axios.get('/get-redeemed').then((response) => {
	      			this.redeemed = response.data
	      		})
	      	},
	      	getPendingOrders(){
	      		axios.get('/get-pending-orders').then((response) => {
	      			this.pendingOrders = response.data
	      		})
	      	},
	      	getRedeemedOrders(){
	      		axios.get('/get-todays-checkins').then((response) => {
	      			this.todaysCheckins = response.data
	      		})
	      	}
		}
	}
</script>