
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example', require('./components/Example.vue'));


window.Event = new Vue({



});



Vue.component('node',{



	props : ['id', 'neighbors', 'cla', 'nodevalues'],

	template: `<button @click="attack" v-bind:class="classobject">{{nodevalue}}({{timerequired}})</button>`,


	data : function()
	{
		return {

			nei : this.neighbors,
			nid: this.id,
			owner: 0, // defender
			nodevalue: this.nodevalues[0], // node value, cost of atatck, timerequired
			cost: this.nodevalues[1],
			timerequired: this.nodevalues[2],
			possessioncounter : 0,

			classObject : {

				  public:  this.cla[0],
  				  normal: 	this.cla[1],
  				  possible:  this.cla[2],
				  attacked:   this.cla[3]
				
			}


		};
	},



	computed : {


		classobject: function()
		{
			return this.classObject
		}


	},


	methods: {

		attack() {



			// when a node is attacked dispatch necessary events and update score 
			// should we allow atatcking again if the node is still in atatcker's posession ?
			if((this.classObject.public==true || this.classObject.possible==true 
				|| this.classObject.attacked==true) 
				&& this.owner==0) // owner is not attacker then allow attack)
			{
				Event.$emit('attack', this.nei, this.id);
				Event.$emit('attackerMoved');
				Event.$emit('resetTimer');
				
			}
			else
			{
				console.log('Can not be attacked');
			}


		}


	},

	created()

	{


		var idd = this.id;
		var classobj = this.classObject;
		var owner = this.owner;
		var vm = this;


		Event.$on('attack', function(neighbors, xid) {


			if(idd != xid)
			{
				for (i = 0; i < neighbors.length; ++i)
				 {
				 	

				 	if(neighbors[i]==idd && classobj.normal==true)
				 	{

	    				console.log('atttcked '+xid+', updating  ' + neighbors[i]);
	    				vm.classObject.possible = true;
	    				vm.classObject.normal = false;

	    				break;
				 	}
				}
			}
			else if(idd == xid)
			{
				
				vm.classObject.attacked = true;
				//classobj.public = false;
				vm.classObject.possible= false;
				vm.owner = 1; // attacker owns node
				console.log('atttcked '+xid + ', owner '+ vm.owner);


				//TODO emit an event for cost, is it incurred every round or just for an attack ?


			}
			
		});


		// Event for collecting points emitted from parent. 
		// check if possessioncounter == timerequired and owner ==1 and the node was attacked
		// then emit event 'returningpoint' with the point

		Event.$on('collectpoints', function(){




			console.log('ON...... event   collectpoints');




			if(vm.possessioncounter < vm.timerequired 
			&& vm.owner==1 && vm.classObject.attacked==true) // else if possessioncounter >= 0, and owner is attckr then just increment the possessioncounter
			{
				vm.possessioncounter += 1;
				console.log('Incrmenting possessioncounter to ' + vm.possessioncounter  + ', node  '+ vm.id);
			}


			if((vm.possessioncounter==vm.timerequired) 
			&& vm.owner==1 && vm.classObject.attacked==true) // owner is attckr
			{
				// reset the counter
				vm.possessioncounter = 0;
				// emit event returningpoint

				console.log('emitting event returningpoint from '+vm.id + ', value '+ vm.nodevalue);

				Event.$emit('returningpoint', vm.nodevalue, vm.id);

			} 



			




		});







	}


});




 
new Vue({

	
	el:"#app",


	data : {


		timer : 5,
		attackermoved : false,
		defendermoved: false,
		numberofround : 1,
		attackerpoints : 0,






	},



	methods : {


			startTimer : function()
			{
				var vm = this
	      		var timer = null
	      		vm.timer = 5
	      		
	      
	      		timer = setInterval(function() 
	      		{


	      			if(vm.timer==5)
			      	{
			      		vm.makeDefenderMove();
			      	}
			      	
			        if(vm.timer==0 && vm.numberofround==3)
			        {

			        	//vm.timer = 'Done...!'
			        	console.log('Game end , numberofround ' + vm.numberofround);

			          	return clearInterval(timer)

			        }


			        if(vm.timer>0)
			        {
			      		vm.timer -= 1;
			      		// make defender move
			      		

			      	}


			      	//if (vm.timer == -1 ) {
			      	//	vm.timer = 5
			      //	}

			      	if(vm.timer == 0 && vm.numberofround < 3) 
			      	{
			        	//vm.timer = 'wait...!';
			        	Event.$emit('checkExitCondition');
			            //return clearInterval(timer)
			        }

		      
		      }, 1000)

			},



			makeDefenderMove: function()
			{

				var vm = this;
				// emit an event 'defendermove'
				//change only the owner
				console.log('making defendermove');

				// select a random node


			}






	},


	created()

	{

		
		var vm = this;
		var timer = this.timer;
		


		// Event for collecting points

		Event.$on('returningpoint', function(nodevalue, nodeid){


			vm.attackerpoints += nodevalue;

			console.log('received points '+ nodevalue + ' from node '+ nodeid);



		});






		// Event when attacker made a move, we have to reset the timer

		Event.$on('resetTimer', function(){

		console.log('event on reseting timer, Timer  ' + vm.timer );


			if(vm.numberofround<3)
			{

				//TODO disable all nodes...
				vm.timer = 0;

				// collect points
				// emit event collect
				console.log('emiting event   collectpoints');
				Event.$emit('collectpoints');



				//TODO update the graph



				

				


				console.log('Timer was resest , numberofround ' + vm.numberofround);


				// start the timer again
				vm.timer = 5;
				// increment number of rounds if it's less than required
				vm.numberofround += 1; // go to the next round
				console.log(' attackermoved is  ' + vm.attackermoved );

				vm.attackermoved = false;
				console.log(' attackermoved is reset to ' + vm.attackermoved );

				//vm.startTimer();

				
			}
			else if(vm.numberofround==3)
			{
				vm.timer = 0;

				console.log('Timer was resest , numberofround ' + vm.numberofround);

				
				console.log('Game end ');
			}

			


		});





		// Event when attacker made a move and we need to set the attackermoved : true;

		Event.$on('attackerMoved', function(){


			console.log(' attackermoved is ' + vm.attackermoved );
			vm.attackermoved = true;
			console.log(' attackermoved is set to ' + vm.attackermoved );

		});


		Event.$on('checkExitCondition', function(){



			console.log('checking exit condition...timer ' + vm.timer + ' vm.attackermoved  ' + vm.attackermoved );

			// if attacker didn't move end the game
			if(vm.attackermoved == false && vm.timer==0)
			{
				vm.numberofround = 3;
				console.log(' Game end ...attacker didnt move' );
			}
			else //reset the move
			{
				
				vm.attackermoved = false;
				
				console.log(' attackermoved was reset to ' + vm.attackermoved );
			}

		});

	}


})
