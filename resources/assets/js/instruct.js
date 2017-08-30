
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

Vue.component('node',{
	props : ['id', 'val', 'hp', 'defcost', 'atkcost'],
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
        return{
            
        };
    }
                
});