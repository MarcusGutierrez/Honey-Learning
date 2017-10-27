
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

Vue.component('gamelog',{
        props : ['nid', 'val', 'atkcost', 'ishp', 'round'],
        template :
                `
                <div v-if="ishp == 0 && val > 0">
                    <font color="green"><b>Successful</b></font> attack on node {{ nid }} (<font color="green"><b>+{{ val - atkcost }}</b></font>)
                </div>
                <div v-else-if="ishp == 1">
                    <font color="red"><b>Failed</b></font> attack on node {{ nid }} (<font color="red"><b>-{{ atkcost }}</b></font>)
                </div>
                <div v-else>
                    <font color="blue"><b>Passed</b></font> turn
                </div>
                `,
    
    data : function(){
        return{
            
        };
    }
                
});

Vue.component('node',{
	props : ['id', 'val', 'hp', 'pub', 'defcost', 'atkcost', 'succ', 'disc', 'neighbors'],
	template: 
            `<div class="node">
                <button @click="tentativeattack" class="btn btn-circle node" v-bind:class="classobject" style="cursor:pointer">
                    <span class="btn btn-circle normal" style="line-height:130%;">
                        <div style="line-height:85%; font-size:22px;" v-if="id == 0">
                            <font color="blue"><br>PASS</font>
                            <br><slot></slot>
                        </div>
                        <div v-else>
                            <div v-if="value > 0">
                                <font color="green">+{{ valueHP }}</font><br><font color="red">-{{ atkCost }}</font>
                            </div>
                            <div v-else-if="valueHP === 'H'">
                                <br><font color="red">-{{ atkCost }}</font>
                            </div>
                            <div v-else>
                                <font color="green">+{{ baseValue - baseAtkCost }}</font>
                            </div>
                        </div>
    
                        
                    </span>
                </button>
                <div style="text-align:center; font-size:25px" v-if="id > 0">
                    <b>{{ defCost }}</b>
                </div>
            </div>`,

	data : function(){
            return {
                testvar: true,
                nid: this.id,
                valueHP: this.val-this.atkcost,
                value: this.val,
                baseValue: this.val,
                
                defCost: this.defcost,
                baseDefCost: this.defcost,
                
                atkCost: this.atkcost,
                baseAtkCost: this.atkcost,
                
                isHP: this.hp,
                isPublic: this.pub,
                pSuccess: this.succ,
                discount: this.disc,
                
                nei : this.neighbors,
                owner: 0, // defender 0 attacker 1
                cost: 0,
                timerequired: 0,
                possessioncounter : 1,

                previous_class : '',
                nodetimer : 0,

                prevclass : '', // reset this in every round
                nomoveallowed : false,

                classObject : {
                    disable:    false,
                    public:     this.pub,
                    normal:     false,
                    possible:   false,
                    attacked:   false,
                    tentative_attacked: false,
                    attacked_regular: false,
                    attacked_honeypot: false
                }

            };
	},

	computed : {
            classobject: function(){
                return this.classObject
            }
	},

	methods: {
            tentativeattack() {
                var vm = this;
                // this is attacker's move
                // emit an event that attacker made a move
                // in the parent only update the move as tentative

                if(vm.nomoveallowed==false){
                    EventListeners.$emit('change-to-tentative',vm.id);
                        
                    if(vm.classObject.possible==true || vm.previous_class === ''){
                        vm.previous_class = 'possible';
                    } else if(vm.classObject.attacked==true || vm.previous_class === ''){
                        vm.previous_class= 'attacked';
                    } else if(vm.classObject.public==true || vm.previous_class === ''){
                        vm.previous_class = 'public';
                    } else if(vm.classObject.normal==true || vm.previous_class === ''){
                        vm.previous_class = 'normal';
                    }
                    
                    EventListeners.$emit('change-to-attacked',vm.id);

                    EventListeners.$emit('attackerMovedconfirmed', vm.nid, 0, 0);
                    EventListeners.$emit('movemade', vm.nid);
                }
            },

            savePrevClass(){
                var vm = this;

                if(vm.classObject.possible==true){
                        vm.prevclass = 'possible';
                }else if(vm.classObject.attacked==true){
                    vm.prevclass = 'attacked';
                }else if(vm.classObject.public==true){
                    vm.prevclass = 'public';
                }else if(vm.classObject.normal==true){
                    vm.prevclass = 'normal';
                }
            }

	},

	created(){
            var vm = this;
    
            EventListeners.$on('reset-prev-class', function(id){
                vm.prevclass = '';
            });
            
            EventListeners.$on('enable-pass-button', function(){
                if(vm.nid == 0)
                    vm.classobject.disable = false;
            });
            
            EventListeners.$on('disable-nodes', function(){
                vm.classobject.disable = true;
            });
            
            
            EventListeners.$on('disable-pass-button', function(){
                if(vm.nid == 0)
                    vm.classobject.disable = true;
            });


            EventListeners.$on('set_nomoveallowed', function(val){
                vm.nomoveallowed = val;
            });

            EventListeners.$on('sendtimer', function(time){
                
            });

            EventListeners.$on('restore-previous-class', function(id){
                if(vm.id == id){
                    vm.classObject.tentative_attacked = false;
                    if(vm.previous_class == 'attacked'){
                            vm.classObject.attacked = true;
                    }else if(vm.previous_class == 'possible' && vm.isPublic(vm.id)!=true){
                        vm.classObject.possible = true;
                    }
                    else if(vm.isPublic(vm.id)==true){
                        vm.classObject.public = true;
                    }
                    else if(vm.previous_class == 'normal'){
                        vm.classObject.normal = true;
                    }
                }
                //vm.prevclass = '';
            });

            EventListeners.$on('change-to-tentative', function(id){
                // this node is clicked for tentative attack
                if(vm.nomoveallowed==false){
                    if(vm.id==id){
                        vm.savePrevClass();
                        vm.classObject.tentative_attacked = true;
                        if(vm.prevclass == 'attacked'){
                                vm.classObject.attacked = false;
                        }else if(vm.prevclass == 'possible'){
                            vm.classObject.possible = false;
                        }else if(vm.prevclass == 'public'){
                            vm.classObject.public = false;
                        }else if(vm.prevclass == 'normal'){
                                vm.classObject.normal = false;
                        }
                    }

                    if(vm.classObject.tentative_attacked==true && vm.id != id){
                        vm.classObject.tentative_attacked = false;
                        if(vm.prevclass == 'attacked'){
                            vm.classObject.attacked = true;
                        }else if(vm.prevclass == 'possible'){
                            vm.classObject.possible = true;
                        }else if(vm.prevclass == 'public'){
                            vm.classObject.public = true;
                        }else if(vm.prevclass == 'normal'){
                            vm.classObject.normal = true;
                        }
                    }
                }
            });
                
                
            EventListeners.$on('change-to-normal', function(idd){
                // if this event id mean to be for the id
                if(vm.id == idd){

                    if(vm.isPublic(vm.id)===true){
                        vm.classObject.public = true;
                        vm.previous_class = 'public';
                    }else{
                        vm.classObject.normal = true;
                        vm.previous_class = 'normal';
                    }

                    vm.classObject.attacked = false;
                    vm.classObject.possible = false;
                    vm.classObject.tentative_attacked = false;

                    // change owner
                    vm.owner = 0;
                    // reset the possessioncounter
                    vm.possessioncounter = 0;
                }
            });

            EventListeners.$on('defender-change-to-normal', function(idd){
                // if this event id mean to be for the id
                if(vm.id == idd){
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
                if(vm.id == idd){
                    vm.previous_class = 'attacked';
                    // change color if not public 
                    //if(vm.classObject.public != true)
                    //{
                    vm.classObject.normal = false;
                    vm.classObject.attacked = false;
                    vm.classObject.possible = false;
                    vm.classObject.public = false;
                    vm.classObject.tentative_attacked = false;
                    vm.classObject.attacked = false;
                    //}

                    // change owner
                    vm.owner = 1;
                    // reset the possessioncounter
                    //vm.possessioncounter = 0;
                }
            });
            
            EventListeners.$on('change-to-attacked-honeypot', function(idd){
                if(vm.nid == idd){
                    vm.classObject.attacked_honeypot = true;
                    vm.classObject.attacked_regular = false;
                    vm.owner = 1;
                }
            });
            
            EventListeners.$on('change-to-attacked-regular', function(idd){
                if(vm.nid == idd){
                    vm.classObject.attacked_honeypot = false;
                    vm.classObject.attacked_regular = true;
                    vm.owner = 1;
                }
            });

            EventListeners.$on('collectpoints', function(){
                if(vm.owner == 1){
                    EventListeners.$emit('returningpoint', vm.id, vm.value, vm.atkCost, vm.isHP);
                    vm.owner = 0;
                    if(vm.isHP){
                        vm.value = 0;
                        vm.valueHP = 'H';
                        EventListeners.$emit('change-to-attacked-honeypot', vm.nid);
                        vm.classObject.public = false;
                    }else{
                        vm.valueHP = 0;
                        vm.value = 0;
                        vm.atkCost = 0;
                        EventListeners.$emit('change-to-attacked-regular', vm.nid);
                        vm.classObject.public = false;
                    }
                    
                    vm.classObject.disable = true;
                    vm.classObject.normal = true;
                    //vm.classObject.attacked = true;
                    //vm.classObject.possible = true;
                    //vm.classObject.public = true;
                    //vm.classObject.tentative_attacked = false;
                }
            });
            
            
            EventListeners.$on('getID', function(){
                EventListeners.$emit('returnID', vm.id, vm.value, vm.atkCost, vm.isHP);
            });

	}

});

new Vue({

    el:"#honeyapp",

    data : {
        //props : ['user_id'],
        //instance: -1,
        user_id : 1,
        attacker_tentative_move : '', // reset the variable when you start a round
        tentative_time_attacker_moved : '', 
        attackerconfirmedmoved : false,
        returndata : '',
        datetime : '',
        
        TIME_LIMIT : 30,
        timer : 30,
        ROUND_LIMIT : 3,
        numberofround : 1,
        attackermoved : false,
        defendermoved: false,
        
        //Attacker params
        attackerbudget : 0,
        attackerpoints : 0,
        totalattackerpoints: 0,
        attackAttempts : 0,
        attackAttemptsBase : 0,
        attackProb : 1.0,
        
        defenderpoints : 0,
        attackeraction : '',
        msgtoplayer : 'Click start',
        gamelog : [],
        currentattackset : [], 
        possibleattackset : [], // initially only the public nodes
        public : [0,1,2,3,4],
        newattackneighbors : [], // need to be resetted in every round
        adjacencymatrix : [
            [0, 1, 1, 0],
            [1, 0, 1, 1],
            [1, 1, 0, 1],
            [0, 1, 1, 0]
        ],

        defenderteststrategy : [0,2,0],
        defenderaction : '',
        defstrategycounter : 0, 

        //user_id : '',

        gamehistory : {
            //gid : 1,
            //uid : '0',
            attacker_action : '',
            time_defender_moved : '',
            time_attacker_moved : '',
            defender_points : 0,
            attacker_points : 0,
            triggered_honeypot : 0
        },
        
    },
    
    mounted(){
        axios.post('/honeytotal').then( response => {
            params = response.data;
            //this.attackerbudget = params['atk_budget'];
            this.attackAttempts = params['atk_attempts'];
            this.attackAttemptsBase = params['atk_attempts'];
            this.defenderpoints = params['total_value'];
            this.totalattackerpoints = params['total_attacker_points'];
            //this.instance = params['round_id'];
            //return this.test;
        })
        .catch(function (error) {
            console.log(error);
        });
        this.startTimer();
    },

    methods : {

        moment: function (date){
            return moment(date);
        },

        date: function (date) {
            return moment(date).toISOString().slice(0, 19).replace('T', ' ');
        },

        saveToDataBase: function(){
            var vm = this;
	   			
            axios.post('/gamehistory/save', {
                    //uid: vm.gamehistory.uid,
                    //gid: vm.gamehistory.gid,
                    atk_attempt: vm.numberofround,
                    //instance: vm.instance,
                    atk_target: vm.gamehistory.attacker_action,
                    //time_defender_moved : vm.gamehistory.time_defender_moved,
                    //time_attacker_moved: vm.gamehistory.time_attacker_moved,
                    time_attacker_moved : Date.now(),
                    def_points: vm.gamehistory.defender_points,
                    atk_points: vm.attackerpoints,
                    honeypotted: vm.gamehistory.triggered_honeypot
            }).then(response => this.returndata = response.data);
        },

        saveToDataBaseTentative: function(){
            var vm = this;
            axios.post('/gamehistory/savetentative', {
                    //uid : vm.gamehistory.uid,
                    //gid : vm.gamehistory.gid,
                    //instance : vm.instance,
                    atk_attempt : vm.numberofround,
                    atk_target : vm.gamehistory.attacker_action,
                    //time_attacker_moved : vm.gamehistory.time_attacker_moved,
                    time_attacker_moved : Date.now(),
            }).then(response => this.returndata = response.data);
            
        },


        confirmAttack : function(){
            var vm = this;
            // TODO
            // work with all necessary avriables
            // set the attcker move
            // set defender move
            if(vm.attacker_tentative_move !== ''){
                EventListeners.$emit('attackerMovedconfirmed', vm.attacker_tentative_move, vm.newattackneighbors, vm.tentative_time_attacker_moved);
            }

        },


        startTimer : function(){
            var vm = this
            var timer = null
            vm.timer = vm.TIME_LIMIT
            vm.msgtoplayer = 'Move before timer goes down to 0';
            $("#nodebuttons").removeClass("disable");
            $("#nodebuttons").removeClass("visible");
            EventListeners.$emit('enable-pass-button');
            $("#startbutton").addClass("disable");
            $("#startbutton").addClass("visible");
            $("#confirmbutton").removeClass("visible");

            EventListeners.$emit('sendtimer', vm.timer);
            EventListeners.$emit('getID');
            //EventListeners.$emit('disable-pass-button');
            
            //axios.post('/defender/uni/1');
            
            timer = setInterval(function() {
                if(vm.timer==vm.TIME_LIMIT) {
                    /*if(vm.defenderaction === ''){
                        vm.makeDefenderMove();
                    }*/
                }
                
                /*if(vm.timer == vm.TIME_LIMIT){
                    EventListeners.$emit('enable-pass-button');
                }*/

                if(vm.timer>0){
                    vm.timer -= 1;
                }else{
                    vm.attacker_tentative_move = 0;
                    vm.attackermoved==true
                    //EventListners.$emit(tentative)
                    EventListeners.$emit('change-to-attacked',0);
                    EventListeners.$emit('attackerMovedconfirmed', vm.attacker_tentative_move, vm.newattackneighbors, vm.tentative_time_attacker_moved);
                    EventListeners.$emit('movemade',vm.attackeraction);
                    EventListeners.$emit('set_nomoveallowed', true);
                }

                if((vm.attackermoved==true) || (vm.attacker_tentative_move !== '' && vm.timer==0)){
                    // the attack is possible if it's inside possivle attack set
                    
                    $("#nodebuttons").addClass("disable");
                    if(vm.timer==0){
                        vm.attackermoved = true;
                        vm.attackeraction = 0;
                        //vm.newattackneighbors = neighbors; 
                        vm.gamehistory.time_attacker_moved = Date.now();
                        vm.gamehistory.attacker_action = vm.attacker_tentative_move;
                    }
                    
                    //vm.gamehistory.defender_action = vm.defenderaction;
                    vm.gamehistory.attacker_action = vm.attackeraction;
                    var possibleindex = vm.isInPossibleAttackSet(vm.possibleattackset, vm.attackeraction);
                    var attackindex = vm.isInAttackSet(vm.currentattackset, vm.attackeraction);
                    
                    /*if(possibleindex > -1 || attackindex > -1){
                        vm.attackermoved = false;
                        //vm.defendermoved = false;
                        EventListeners.$emit('movemade',vm.attackeraction);
                    }*/
                    
                    if(vm.attackAttempts == 0){
                        //vm.timer = 'Done...!'
                        //EventListeners.$emit('last-round-update');

                        $("#nodebuttons").addClass("disable");
                        $('#nextbutton').removeClass("visible");
                        $('#nextbutton').removeClass("disable");
                        $("#confirmbutton").addClass("visible");

                        //END HERE!
                        axios.post('/round/store').then(function (response){
                            console.log(response)
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                        return clearInterval(timer);
                    }
                }

            }, 1000)
        },

        //checks whether the attacked 
        isInPossibleAttackSet : function(possibleattackset, attackeraction){
            for(var i =0; i<possibleattackset.length; i++){
                if(possibleattackset[i] == attackeraction){
                    return i;
                }
            }
            return -1;
        },
        
        //checks whether the attacked 
        isInAttackSet : function(attackset, attackeraction){
            for(var i=0; i<attackset.length; i++){
                if(attackset[i] == attackeraction){
                        return i;
                }
            }
            return -1;
        },

        // after both players move we need to update the 
        // currentattackset, possibleattackset
        // also removes defender action from the attackset 
        updateAttackSets: function(){
            var vm = this;
            // a) update attack set
            var attacksetindex = vm.isInAttackSet(vm.currentattackset, vm.attackeraction);
            if(attacksetindex == -1){
                vm.currentattackset.push(vm.attackeraction);
            }

            // remove attacker action from possibleattackset
            var indx = vm.isInPossibleAttackSet(vm.possibleattackset, vm.attackeraction);
            if(indx > 0){
                vm.possibleattackset.splice(indx, 1);
            }
            // b) update possible attack set 
            //vm.possibleattackset = vm.possibleattackset.concat(vm.newattackneighbors);
            // c) remove defender action from attack set
            // find the index of the element
            var index = vm.isInAttackSet(vm.currentattackset, vm.defenderaction);
            var foundinattackset = false;
            if(index > -1 ){
                foundinattackset = true;
                vm.currentattackset.splice(index, 1);

            }
            
            return foundinattackset;
        },



        hasAttackNeighbor: function(attackset, defenderaction){
            var vm = this;

            for(var i=0; i<vm.adjacencymatrix[defenderaction].length; i++){
                if(vm.adjacencymatrix[defenderaction][i]==1){
                    var hasneighbor = vm.isInAttackSet(attackset, i);
                    if(hasneighbor > -1){
                        return true;
                    }
                }
            }
            return false;
        },

        // make the nodes to normal where defender made move
        // also make the possible nodes to normal if it's a neighbor of defender action
        updateDefenderNeighbors : function(){
            var vm = this;
            // ALso we need to update the possible attackset
            //for every neighbor of defender action
            for(var j=0; j<vm.adjacencymatrix[vm.defenderaction].length; j++){
                if(vm.adjacencymatrix[vm.defenderaction][j]==1){ // if there is an edge
                    var neighbor = j;
                    // first check if it;s in possible atatckset
                    var possibleindex = vm.isInPossibleAttackSet(vm.possibleattackset, neighbor);
                    if(possibleindex > -1){
                        // check if neighbor has any neighbor who is in attackset

                        var neighborhasattacksetneighbor = false;
                        for(var k=0; k<vm.adjacencymatrix[neighbor].length; k++){
                            if(vm.adjacencymatrix[neighbor][k]==1){
                                var neineighbor = k;
                                // check if neineighbor is in attackset
                                var attackindex = vm.isInAttackSet(vm.currentattackset, neineighbor);
                                if(attackindex > -1){
                                    neighborhasattacksetneighbor = true;
                                    break;
                                }
                            }
                        }
                        if(!neighborhasattacksetneighbor){
                            EventListeners.$emit('change-to-normal', neighbor);
                            vm.possibleattackset.splice(possibleindex, 1);
                        }
                    }
                }
            }
        }

    },

    created(){
        $("#nodebuttons").addClass("disable");
        $("#confirmbutton").addClass("disable");
        //$("#startbutton").removeClass("disable");

        var vm = this;
        vm.datetime = Date.now();
    
        EventListeners.$on('checkExitCondition', function(){

            var foundinattackset = vm.isInAttackSet(vm.currentattackset, vm.defenderaction);
            if(foundinattackset==true){
                EventListeners.$emit('change-to-normal', vm.defenderaction);
            }

            //EventListeners.$emit('collectpoints');

            // if attacker didn't move end the game
            if(vm.attackermoved == false && vm.timer==0){
                vm.numberofround = vm.attackAttemptsBase;
            }
        });



        EventListeners.$on('returningpoint', function(nodeid, nodevalue, atkcost, ishp){
            if(ishp == 1){
                vm.attackerpoints -= atkcost;
                vm.totalattackerpoints -= atkcost;
                vm.valueHP = 'H';
                vm.gamehistory.triggered_honeypot = 1;
            }else{
                vm.attackerpoints += nodevalue - atkcost;
                vm.totalattackerpoints += nodevalue - atkcost;
                vm.defenderpoints -= nodevalue;
            }
            vm.gamelog.unshift([nodeid, nodevalue, atkcost, ishp, vm.numberofround]);
        });

        EventListeners.$on('attackerMovedtentative', function(id, neighbors, tentative_time_attacker_moved){
            // just update the tentative move
            $("#confirmbutton").removeClass("disable");
            vm.attacker_tentative_move = id;
            vm.tentative_time_attacker_moved = tentative_time_attacker_moved;

            vm.attackeraction = id;
            vm.newattackneighbors = neighbors; 
            vm.gamehistory.time_attacker_moved = vm.tentative_time_attacker_moved;
            vm.gamehistory.attacker_action = id;


            vm.saveToDataBaseTentative();
        });

        // Event when attacker made a move and we need to set the attackermoved : true;
        EventListeners.$on('attackerMovedconfirmed', function(id, neighbors, time_attacker_moved){
            vm.attackermoved = true;
            vm.attackeraction = id;
            vm.newattackneighbors = neighbors; 
            vm.gamehistory.time_attacker_moved = time_attacker_moved;
            vm.gamehistory.attacker_action = id;
            vm.attackerbudget -= vm.attackerbudget / vm.attackAttempts;
            vm.attackAttempts -= 1;
            //alert(vm.attackAttempts);
            $("#nodebuttons").addClass("disable");
        });



		

        //event listener when both defender and atatcker completed their moves
        // handler for bothmoved
        EventListeners.$on('movemade', function(attackeraction){
            EventListeners.$emit('collectpoints');
            
            while (vm.currentattackset.length > 0) {
                vm.currentattackset.pop();
            }
            vm.gamehistory.attacker_action = attackeraction;
            vm.attacker_tentative_move  = attackeraction;

            //save to database
            vm.saveToDataBase();

            vm.attacker_tentative_move = '';
            vm.gamehistory.triggered_honeypot = 0;
            EventListeners.$emit('set_nomoveallowed', true);
            EventListeners.$emit('disable-nodes');
        });
        
        EventListeners.$on('returnID', function(nodeid, nodevalue, atkcost, ishp){
            vm.possibleattackset.push(nodeid);
        });
    }
});