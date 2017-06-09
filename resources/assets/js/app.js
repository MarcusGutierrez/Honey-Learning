
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


	
window.EventListeners = new Vue({



});



Vue.component('node',{



	props : ['id', 'neighbors', 'cla', 'nodevalues'],

	template: `<button @click="tentativeattack" v-bind:class="classobject">{{nodevalue}}({{timerequired}})</button>`,


	data : function()
	{
		return {

			nei : this.neighbors,
			nid: this.id,
			owner: 0, // defender 0 attacker 1
			nodevalue: this.nodevalues[0], // node value, cost of atatck, timerequired
			cost: this.nodevalues[1],
			timerequired: this.nodevalues[2],
			possessioncounter : 0,
			publicnodes : [0], 

			previous_class : '',

			prevclass : '', // reset this in every round
			nomoveallowed : false,
			classObject : {

				  public:  this.cla[0],
  				  normal: 	this.cla[1],
  				  possible:  this.cla[2],
				  attacked:   this.cla[3],
				  tentative_attacked : false
				
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

		tentativeattack() {


			var vm = this;

			// this is attacker's move
			// emit an event that attacker made a move
			// in the parent only update the move as tentative



			if(vm.nomoveallowed==false)
			{

				if(vm.classObject.public == true || vm.classObject.possible==true || vm.classObject.tentative_attacked == true || vm.classObject.attacked==true)
				{

					EventListeners.$emit('change-to-tentative',vm.id);

					if(vm.classObject.possible==true || vm.previous_class === '')
					{
						vm.previous_class = 'possible';
					}
					else if(vm.classObject.attacked==true || vm.previous_class === '')
					{
						vm.previous_class= 'attacked';
					}
					else if(vm.classObject.public==true || vm.previous_class === '')
					{
						vm.previous_class = 'public';
					}
					else if(vm.classObject.normal==true || vm.previous_class === '')
					{
						vm.previous_class = 'normal';
					}

					EventListeners.$emit('attackerMovedtentative', vm.id, vm.neighbors, Date.now());
				}
				else
				{
					//console.log('Need to attack public or possible or tentative nodes');

				}
			}

			

		},

		savePrevClass(){

			var vm = this;

			if(vm.classObject.possible==true)
			{
				vm.prevclass = 'possible';
			}
			else if(vm.classObject.attacked==true)
			{
				vm.prevclass = 'attacked';
			}
			else if(vm.classObject.public==true)
			{
				vm.prevclass = 'public';
			}
			else if(vm.classObject.normal==true)
			{
				vm.prevclass = 'normal';
			}
			




		}


	},

	created()

	{
		var vm = this;

		EventListeners.$on('reset-prev-class', function(id)
		{
				

				vm.prevclass = '';
		});


		EventListeners.$on('set_nomoveallowed', function(val){
			

			vm.nomoveallowed = val;
		});



		EventListeners.$on('restore-previous-class', function(id)
		{
				

				
				if(vm.id == id)
				{
					console.log('restore-previous-class '+ vm.previous_class + ' id '+ id);
					vm.classObject.tentative_attacked = false;
					if(vm.previous_class == 'attacked')
					{
						vm.classObject.attacked = true;

					}
					else if(vm.previous_class == 'possible' && vm.publicnodes[0] != vm.id)
					{
						vm.classObject.possible = true;

					}
					else if(vm.publicnodes[0] == vm.id )
					{
						vm.classObject.public = true;

					}
					else if(vm.previous_class == 'normal')
					{
						vm.classObject.normal = true;

					}
				}

				//vm.prevclass = '';
		});



		EventListeners.$on('change-to-tentative', function(id){

			// this node is clicked for tentative attack

			if(vm.nomoveallowed==false)
			{


				if(vm.id==id)
				{
					vm.savePrevClass();
					vm.classObject.tentative_attacked = true;
					if(vm.prevclass == 'attacked')
					{
						vm.classObject.attacked = false;

					}
					else if(vm.prevclass == 'possible')
					{
						vm.classObject.possible = false;

					}
					else if(vm.prevclass == 'public')
					{
						vm.classObject.public = false;

					}
					else if(vm.prevclass == 'normal')
					{
						vm.classObject.normal = false;

					}
					


				}
				
				if(vm.classObject.tentative_attacked==true && vm.id != id)
				{
					vm.classObject.tentative_attacked = false;
					if(vm.prevclass == 'attacked')
					{
						vm.classObject.attacked = true;

					}
					else if(vm.prevclass == 'possible')
					{
						vm.classObject.possible = true;

					}
					else if(vm.prevclass == 'public')
					{
						vm.classObject.public = true;

					}
					else if(vm.prevclass == 'normal')
					{
						vm.classObject.normal = true;

					}

				}
			}



		});


		EventListeners.$on('change-to-normal', function(idd){


			// if this event id mean to be for the id
			if(vm.id == idd)
			{
				

				//console.log('on change-to-normal event....node '+ idd);
				// change color if not public 
				//if(vm.classObject.public != true)
				//{
					
					if(vm.id==vm.publicnodes[0])
					{
						vm.classObject.public = true;
						vm.previous_class = 'public';
					}
					else
					{
						vm.classObject.normal = true;
						vm.previous_class = 'normal';

					}
					
					vm.classObject.attacked = false;
					vm.classObject.possible = false;
					vm.classObject.tentative_attacked = false;
				//}


				

				// change owner
				vm.owner = 0;

				// reset the possessioncounter
				vm.possessioncounter = 0;

			}

		});





		EventListeners.$on('defender-change-to-normal', function(idd){


			// if this event id mean to be for the id
			if(vm.id == idd)
			{

				console.log('on defender-change-to-normal event....node '+ idd);
				// change color if not public 
				//if(vm.classObject.public != true)
				//{
					//if(vm.id==vm.publicnodes[0])
					//{
					//	vm.classObject.public = true;
					//}
					//else
					//{
					//	vm.classObject.normal = true;

					//}
					
					//vm.classObject.attacked = false;
					//vm.classObject.possible = false;
				//}


				

				// change owner
				vm.owner = 0;

				// reset the possessioncounter
				vm.possessioncounter = 0;

			}

		});



		EventListeners.$on('change-to-attacked', function(idd){


			

			// if this event id mean to be for the id
			//console.log('here i am .....fcuk u ######### this-id '  +vm.id + ' idd '+ idd);
			if(vm.id == idd)
			{
				vm.previous_class = 'attacked';
				console.log('change-to-attacked event....node '+ idd);
				// change color if not public 
				//if(vm.classObject.public != true)
				//{
					vm.classObject.normal = false;
					vm.classObject.attacked = true;
					vm.classObject.possible = false;
					vm.classObject.public = false;
					vm.classObject.tentative_attacked = false;
				//}


				

				// change owner
				vm.owner = 1;

				// reset the possessioncounter
				//vm.possessioncounter = 0;

			}

		});


		EventListeners.$on('change-to-possible', function(nodeids){


			for(var i=0; i<nodeids.length; i++)
			{


				// if this event id mean to be for the id
				if(vm.id == nodeids[i])
				{
					vm.previous_class = 'possible';
					console.log('on change-to-possible event....node '+ vm.id);
					// change color if not public 
					//if(vm.classObject.public != true)
					//{
						vm.classObject.normal = false;
						//vm.attacked = false;
						vm.classObject.attacked = false;
						if(vm.id==vm.publicnodes[0])
						{
							vm.classObject.public = true;
						}
						else
						{
							vm.classObject.possible = true;

						}
						vm.classObject.tentative_attacked = false;
					//}


					

					// change owner even if you are updating the neighbor,
					// because we are using the same event listener to change an attacjked
					// ndoe to possible when defender regains control over this node. 
					vm.owner = 0;

					// reset the possessioncounter
					vm.possessioncounter = 0;
					break;

				}
			}

		});


		EventListeners.$on('collectpoints', function(){


			console.log('ON...... event   collectpoints');
			console.log( 'id: '+vm.nid+' vm.possessioncounter '+ vm.possessioncounter + ' owner '+ vm.owner);




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

				EventListeners.$emit('returningpoint', vm.nodevalue, vm.id);

			} 




		});


		

		
		





	}


});










	new Vue({

	
	el:"#app",


	data : {
		attacker_tentative_move : '', // reset the variable when you start a round
		tentative_time_attacker_moved : '', 
		attackerconfirmedmoved : false,
		returndata : '',
		datetime : '',
		TIME_LIMIT : 5,
		ROUND_LIMIT : 3,
		timer : 21,
		numberofround : 1,
		attackermoved : false,
		defendermoved: false,
		attackerpoints : 0,
		defenderaction : '',
		attackeraction : '',
		msgtoplayer : 'Click start',
		currentattackset : [], 
		possibleattackset : [0], // initially only the public nodes
		public : [0],
		newattackneighbors : [], // need to be resetted in every round
		adjacencymatrix : [
					
					[0, 1, 1, 0],
					[1, 0, 1, 1],
					[1, 1, 0, 1],
					[0, 1, 1, 0]
		],

		defenderteststrategy : [0,0,0],
		defstrategycounter : 0, 

		gamehistory : {


			gameid : 1,
			userid : 1,
			defender_action : '',
			attacker_action : '',
			time_defender_moved : '',
			time_attacker_moved : '',
			defender_points : 0,
			attacker_points : 0



		},






	},



	methods : {


			 moment: function (date) 
			 {

     			 return moment(date);
   			 },


			date: function (date) 
			{
	      		return moment(date).toISOString().slice(0, 19).replace('T', ' ');
	   		},


	   		saveToDataBase: function()
	   		{
	   			var vm = this;
	   			//console.log('*********** saving in database');
	   			axios.post('/gamehistory/save', {
	   				userid : vm.gamehistory.userid,
	   				gameid : vm.gamehistory.gameid,
	   				defender_action : vm.gamehistory.defender_action,
	   				attacker_action : vm.gamehistory.attacker_action,
	   				time_defender_moved : vm.gamehistory.time_defender_moved,
	   				time_attacker_moved : vm.gamehistory.time_attacker_moved,
	   				defender_points : vm.gamehistory.defender_points,
	   				attacker_points : vm.attackerpoints

	   			}).then(response => this.returndata = response.data);
	   		},


	   		saveToDataBaseTentative: function()
	   		{
	   			var vm = this;
	   			//console.log('*********** saving in database');
	   			axios.post('/gamehistory/savetentative', {
	   				userid : vm.gamehistory.userid,
	   				gameid : vm.gamehistory.gameid,
	   				round : vm.numberofround,
	   				defender_action : vm.defenderaction,
	   				attacker_action : vm.gamehistory.attacker_action,
	   				time_defender_moved : vm.gamehistory.time_defender_moved,
	   				time_attacker_moved : vm.gamehistory.time_attacker_moved,
	   				defender_points : vm.gamehistory.defender_points,
	   				attacker_points : vm.attackerpoints

	   			}).then(response => this.returndata = response.data);

	   		},


	   		confirmAttack : function()
	   		{
	   			var vm = this;
	   			// TODO
	   			// work with all necessary avriables
	   			// set the attcker move
	   			// set defender move
	   			if(vm.attacker_tentative_move !== '')
			     {
			      	
			      			
			      	EventListeners.$emit('attackerMovedconfirmed', vm.attacker_tentative_move, vm.newattackneighbors, vm.tentative_time_attacker_moved);
			      }
	   			

	   		},


			startTimer : function()
			{
				var vm = this
	      		var timer = null
	      		vm.timer = vm.TIME_LIMIT
	      		vm.msgtoplayer = 'Move before timer goes down to 0';
	      		$("#nodebuttons").removeClass("disable");
	      
	      		timer = setInterval(function() 
	      		{

	      			console.log('Round ****************** '+ vm.numberofround);


	      			if(vm.timer==vm.TIME_LIMIT)
			      	{
			      		vm.makeDefenderMove();
			      	}

			      	if(vm.timer==0 && vm.numberofround==vm.ROUND_LIMIT)
			        {

			        	//vm.timer = 'Done...!'
			        	//EventListeners.$emit('last-round-update');
			        	vm.msgtoplayer = 'Game End';
			        	console.log('Game end , numberofround ' + vm.numberofround);
			        	$("#app").addClass("disable");
			          	return clearInterval(timer)

			        }

			      	if(vm.timer>0)
			        {
			      		vm.timer -= 1;
			      		
			      		

			      	}
			      	if(vm.timer <= 1)
			      	{
			      		EventListeners.$emit('set_nomoveallowed', true);
			      	}

			      	if(vm.timer == 0 && vm.numberofround <= vm.ROUND_LIMIT) 
			      	{
			      		console.log('>>>>>>>>> vm.attacker_tentative_move '+ vm.attacker_tentative_move );

			      		if(vm.attacker_tentative_move !== '')
			      		{
			      			
			      			
			      			//EventListeners.$emit('attackerMovedconfirmed', vm.attacker_tentative_move, vm.newattackneighbors, vm.tentative_time_attacker_moved);
			      		}
			      		else
			      		{
				      		//console.log('checking exit conditionss &&&&&&&&&&&&&&&&&&');
				        	//vm.timer = 'wait...!';
				        	EventListeners.$emit('checkExitCondition');
			        	}
			            //return clearInterval(timer)
			        }

			      	console.log('vm.defendermoved '+vm.defendermoved + ', vm.attackermoved '+ vm.attackermoved);


			      	if((vm.defendermoved==true && vm.attackermoved==true) || (vm.attacker_tentative_move !== '' && vm.timer==0))
			      	{

			      		// the attack is possible if it's inside possivle attack set

			      		$("#nodebuttons").addClass("disable");
			      		if(vm.timer==0)
			      		{
			      			vm.attackermoved = true;
							//console.log('attackermoved is set to ' + vm.attackermoved );
							vm.attackeraction = vm.attacker_tentative_move;
							//vm.newattackneighbors = neighbors; 
							vm.gamehistory.time_attacker_moved = vm.date(vm.tentative_time_attacker_moved);
							vm.gamehistory.attacker_action = vm.attacker_tentative_move;
			      		}

			      		
			      		vm.gamehistory.defender_action = vm.defenderaction;
			      		vm.gamehistory.attacker_action = vm.attackeraction;



			      		var possibleindex = vm.isInPossibleAttackSet(vm.possibleattackset, vm.attackeraction);
			      		var attackindex = vm.isInAttackSet(vm.currentattackset, vm.attackeraction);

			      		//console.log('%%%%%%%  possibleindex '+ possibleindex + ' attackindex '+ attackindex);
			      		if(possibleindex > -1 || attackindex > -1)
			      		{


							vm.attackermoved = false;
							vm.defendermoved = false;
							
				      		EventListeners.$emit('bothmoved',vm.defenderaction, vm.attackeraction);
				      		
			      		}
			      		else
			      		{
			      			//console.log('Invalid attack ##########');

			      		}
			      		
			      	}
			      	
			      

		      
		      }, 1000)

			},


			//checks whether the attacked 
			isInPossibleAttackSet : function(possibleattackset, attackeraction)
			{
				
				for(var i =0; i<possibleattackset.length; i++)
				{
					//console.log('innnn ******* i '+ i);
					if(possibleattackset[i] == attackeraction)
					{
						//console.log('found '+attackeraction+' in possible attack set ');
						return i;
					}
				}
				//console.log('didnt found '+attackeraction+' in possible attack set ');
				return -1;

			},


			//checks whether the attacked 
			isInAttackSet : function(attackset, attackeraction)
			{
				for(var i=0; i<attackset.length; i++)
				{
					if(attackset[i] == attackeraction)
					{
						//console.log('found '+attackeraction+' in  attack set ');
						return i;
					}
				}
				//console.log('didnt found '+attackeraction+' in  attack set ');
				return -1;

			},



			// function to make a move for defender
			makeDefenderMove : function()
			{


				var vm = this;
				//console.log('1111111111   defender moved....');

				// select a random node
				 var defaction = vm.defenderteststrategy[vm.defstrategycounter];
				 vm.gamehistory.time_defender_moved = vm.date(Date.now());

				 vm.defstrategycounter += 1;
				  //Math.floor((Math.random() * 4) + 0);
				 vm.defenderaction = defaction;
				// console.log('Defender action '+ vm.defenderaction);
				// console.log('defendermoved is ' + vm.defendermoved );
				vm.defendermoved = true;
				//console.log('defendermoved is set to ' + vm.defendermoved );


			},


			// after both players move we need to update the 
			// currentattackset, possibleattackset
			// also removes defender action from the attackset 
			updateAttackSets: function()
			{
				var vm = this;

				// a) update attack set

				var attacksetindex = vm.isInAttackSet(vm.currentattackset, vm.attackeraction);

				if(attacksetindex == -1)
				{
					vm.currentattackset.push(vm.attackeraction);
				}

				// remove attacker action from possibleattackset
				var indx = vm.isInPossibleAttackSet(vm.possibleattackset, vm.attackeraction);
				if(indx > -1)
				{
					vm.possibleattackset.splice(indx, 1);
				}


				console.log(' $$$$$$$ new attack neighbor before updating...');
				for (var i = 0; i <vm.newattackneighbors.length ; i++) 
				{
	    			console.log(vm.newattackneighbors[i]);


				}

				//console.log(' $$$$$$$ possible attack set before updating...');
				for (var i = 0; i <vm.possibleattackset.length ; i++) 
				{
	    			//console.log(vm.possibleattackset[i]);


				}
				// b) update possible attack set 
				//vm.possibleattackset = vm.possibleattackset.concat(vm.newattackneighbors);

				for(var i=0; i < vm.newattackneighbors.length; i+=1)
				{
					// check for duplicates

					//console.log('b ******* i '+ i);
					var newattackneighbor = vm.newattackneighbors[i];
					var index = vm.isInPossibleAttackSet(vm.possibleattackset, newattackneighbor);
					// also need to check if it's in currentattakset
					var index2 = vm.isInAttackSet(vm.currentattackset, newattackneighbor);
					//console.log('a ******* i '+ i);
					if((index == -1) && (index2 == -1))
					{
						//console.log('pushing element '+ newattackneighbor + ' into possibleattackset');
						vm.possibleattackset.push(newattackneighbor);
					} 
					//console.log('LALALALALALAL');
				}





				console.log(' $$$$$$$ Current attack set ');
				for (var i = 0; i <vm.currentattackset.length ; i++) 
				{
	    			//console.log(vm.currentattackset[i] + ' ');
				}


				console.log(' $$$$$$$ possible attack set after updating....');
				for (var i = 0; i <vm.possibleattackset.length ; i++) 
				{
	    			//console.log(vm.possibleattackset[i]);


				}

				// c) remove defender action from attack set
				// find the index of the element
				var index = vm.isInAttackSet(vm.currentattackset, vm.defenderaction);
				
				var foundinattackset = false;

				if(index > -1 )
				{
					foundinattackset = true;
					//console.log('removing node '+ vm.defenderaction + ' index '+ index);
					vm.currentattackset.splice(index, 1);
					//console.log(' $$$$$$$ Current attack set ');
					for (var i = 0; i <vm.currentattackset.length ; i++) 
					{
		    			//console.log(vm.currentattackset[i] + ' ');
					}

				}
				else
				{
					//console.log('defender action is not in current attack set ');
				}


				//console.log(' $$$$$$$ Current attack set ');
				for (var i = 0; i <vm.currentattackset.length ; i++) 
				{
		    		//console.log(vm.currentattackset[i] + ' ');
				}

				return foundinattackset;

			},



			hasAttackNeighbor: function(attackset, defenderaction)
			{
				var vm = this;

				for(var i=0; i<vm.adjacencymatrix[defenderaction].length; i++)
				{
					if(vm.adjacencymatrix[defenderaction][i]==1)
					{

						var hasneighbor = vm.isInAttackSet(attackset, i);
						if(hasneighbor > -1)
						{
							return true;
						}
					}
				}
				return false;
			},

			// make the nodes to normal where defender made move
			// also make the possible nodes to normal if it's a neighbor of defender action
			updateDefenderNeighbors : function()
			{

				var vm = this;

				// ALso we need to update the possible attackset
				//for every neighbor of defender action
				for(var j=0; j<vm.adjacencymatrix[vm.defenderaction].length; j++)
				{
					if(vm.adjacencymatrix[vm.defenderaction][j]==1) // if there is an edge
					{
						var neighbor = j;

						// first check if it;s in possible atatckset


						var possibleindex = vm.isInPossibleAttackSet(vm.possibleattackset, neighbor);

						if(possibleindex > -1)
						{
							//console.log('neighbor ' + neighbor + ' is in possibleattackset ');
							//console.log('need to update as normal ifffffff  doesnt have any neighbor in attackset');
							// check if neighbor has any neighbor who is in attackset

							var neighborhasattacksetneighbor = false;

							for(var k=0; k<vm.adjacencymatrix[neighbor].length; k++)
							{
								if(vm.adjacencymatrix[neighbor][k]==1)
								{
									var neineighbor = k;
									// check if neineighbor is in attackset
									var attackindex = vm.isInAttackSet(vm.currentattackset, neineighbor);
									if(attackindex > -1)
									{
										//console.log('%%%%% found neighbor of node '+ neineighbor + ' in attackset');
										//console.log('No need to update as normal it  has  neighbor  in atatckset');
										neighborhasattacksetneighbor = true;
										break;
									}
									
								}
							}
							if(!neighborhasattacksetneighbor)
							{	
								//console.log('%%%%% found no neighbor of node '+ neineighbor + ' in attackset');
								//console.log('need to update as normal it  has  neighbor  in atatckset');

								EventListeners.$emit('change-to-normal', neighbor);

								//console.log('removing node '+neighbor+' from possible attackset'); 

								vm.possibleattackset.splice(possibleindex, 1);

								//console.log(' $$$$$$$ possible attack set ');
								for (var i = 0; i <vm.possibleattackset.length ; i++) 
								{
					    			//console.log(vm.possibleattackset[i]);

								}



							}



						}
						else
						{
							//console.log('neighbor ' + neighbor + ' is not in possibleattackset ');
							//console.log('Dont need to update');
						}
					}
				}
			}



	

	},


	created () {



			$("#nodebuttons").addClass("disable");
			$("#confirmbutton").addClass("disable");
			//$("#startbutton").removeClass("disable");

			var vm = this;


			vm.datetime = vm.date(Date.now());



			EventListeners.$on('checkExitCondition', function()
			{



				//console.log('checking exit condition...timer ' + vm.timer + ' vm.attackermoved  ' + vm.attackermoved );

				// if attacker didn't move end the game
				if(vm.attackermoved == false && vm.timer==0)
				{
					vm.numberofround = vm.ROUND_LIMIT;
					//console.log(' Game end ...attacker didnt move' );
				}
				
		});



			EventListeners.$on('returningpoint', function(nodevalue, nodeid)
			{


				vm.attackerpoints += nodevalue;

				//console.log('received points '+ nodevalue + ' from node '+ nodeid);



			});


			EventListeners.$on('attackerMovedtentative', function(id, neighbors, tentative_time_attacker_moved)
			{


				// just update the tentative move
				$("#confirmbutton").removeClass("disable");
				console.log('attacker tentative move '+ id)
				vm.attacker_tentative_move = id;
				vm.tentative_time_attacker_moved = vm.date(tentative_time_attacker_moved);

				//console.log('tttttttttt   attacker tentative attacked  node ' + id + ', tentative time' + vm.tentative_time_attacker_moved);
				//console.log('attacker_tentative_move is ' + vm.attacker_tentative_move );

				vm.attackeraction = id;
				vm.newattackneighbors = neighbors; 
				vm.gamehistory.time_attacker_moved = vm.tentative_time_attacker_moved;
				vm.gamehistory.attacker_action = id;


				vm.saveToDataBaseTentative();


			});




		// Event when attacker made a move and we need to set the attackermoved : true;

		EventListeners.$on('attackerMovedconfirmed', function(id, neighbors, time_attacker_moved){

			//console.log('222222222   confirming attack......attacker attacked  node ' + id );
			//console.log('attackermoved is ' + vm.attackermoved );
			
			vm.attackermoved = true;
			//console.log('attackermoved is set to ' + vm.attackermoved );
			vm.attackeraction = id;
			vm.newattackneighbors = neighbors; 
			vm.gamehistory.time_attacker_moved = vm.date(time_attacker_moved);
			vm.gamehistory.attacker_action = id;
			

		});



		

		//event listener when both defender and atatcker completed their moves
		// handler for bothmoved
		EventListeners.$on('bothmoved', function(defenderaction, attackeraction){


			console.log('%%%%%%%%% bothmoved, defenderaction '+ defenderaction + ' attackeraction '+ attackeraction);
			//console.log('Timer is '+ vm.timer);
			vm.msgtoplayer = 'wait...';
			vm.timer = 0;
			//console.log('Timer is reset to '+ vm.timer);





			
			//TODO disable every button click or disable the whole div :D
			
			//$("#app2").addClass("disable");
			





			// save the data to the server
						

			// emit an event 
			

			if(vm.defenderaction != vm.attackeraction)
			{
					EventListeners.$emit('change-to-attacked', vm.attackeraction);
					// update the attack sets
					var foundinattackset = vm.updateAttackSets();

					//console.log('foundinattackset '+ foundinattackset);


					//console.log('dispatching events to attacked and possible nodes ');


					// dispatch event to update attcker action as attacked
					// also dispatch event to set the neighbor of atatcker 

					

					for(var k =0; k< vm.newattackneighbors.length; k++)
					{
						var isinattackset = vm.isInAttackSet(vm.currentattackset ,vm.newattackneighbors[k]);
						if(isinattackset == -1)
						{
							var nei  = [vm.newattackneighbors[k]];
							EventListeners.$emit('change-to-possible', nei);
						}
					}
					



					// dispatch an event to set the defender action as normal 
					// if the defender action(the node) was not normal already


					//var possibleindex = vm.isInPossibleAttackSet(vm.possibleattackset, vm.defenderaction);

					// if a defender action is in possible atack set we don't do anyt ing 
					// becasue it will still have a atatcked node as neigbor 

					
					if(foundinattackset)
					{
						
						var hasneiborattackset = vm.hasAttackNeighbor(vm.currentattackset, vm.defenderaction);
						// if it does not have any neighbor from atatckset 
						if(hasneiborattackset == false)
						{

							EventListeners.$emit('change-to-normal', vm.defenderaction);
						}
						else // if it has then change to possible
						{
							// add it to possible list if not in it already
							var possibleindex = vm.isInAttackSet(vm.possibleattackset, vm.defenderaction);

							if(possibleindex == -1)
							{
								vm.possibleattackset.push(vm.defenderaction);
							}

							var defaction = [vm.defenderaction];
							EventListeners.$emit('change-to-possible', defaction);

						}
						// update defender action neighbor n
						// if  n has a neighbor in attackset then don't update
						// if n has no neigbor inatatckset then update to normal
						//console.log('@@@@@@ updating neighbors of defender action '+ vm.defenderaction);
						// we make a node normal if it's in atatck set
						// and make the neighbors of these nodes as normal if they don;t have any neighbor in attackset
						vm.updateDefenderNeighbors();


					}
					else
					{
						// we don;t need to dispatch an event if defender action is not in attck set
						// if it's in possible atatckset that won't make any difference. 
						//console.log('defender action is not in attackset..So we dont need to update the graph ');
					}
			}
			else
			{
				EventListeners.$emit('restore-previous-class', vm.defenderaction);
			}
			


			// we need to dispatch event to collect points

			EventListeners.$emit('collectpoints');


			
			//console.log('after collecting points ************** numberofround '+ vm.numberofround + ' timer '+ vm.timer);

			console.log(' $$$$$$$ Current attack set ');
			for (var i = 0; i <vm.currentattackset.length ; i++) 
			{
	    		console.log(vm.currentattackset[i] + ' ');
			}



			console.log(' $$$$$$$ possible attack set ');
			for (var i = 0; i <vm.possibleattackset.length ; i++) 
			{
				console.log(vm.possibleattackset[i]);

			}


			//save to database
			vm.saveToDataBase();



			// reset gamehisotry variables
			// Is it necessary???

			vm.attacker_tentative_move = '';
			EventListeners.$emit('set_nomoveallowed', false);
			EventListeners.$emit('reset-prev-class', vm.attackeraction);

			// reset 
			if(vm.numberofround<vm.ROUND_LIMIT)
			{
				// reset the timer 
			    vm.timer = vm.TIME_LIMIT;
				vm.numberofround += 1;
			}
			//console.log('after collecting points ************** numberofround '+ vm.numberofround + ' timer '+ vm.timer);

			vm.msgtoplayer = 'make a move before timer goes down to 0';

			$("#nodebuttons").removeClass("disable");
			$("#confirmbutton").addClass("disable");

			






		});




	}


	

});




