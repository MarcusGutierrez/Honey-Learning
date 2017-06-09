var vm = new Vue({
  el: '#regform',

  data: 
  {
    school : '',
    favpet : '',
    age : '',
    user_id : ''
    


  },


  methods: 
  {
    createId : function()
    {
      this.user_id =   this.school + this.favpet + this.age;
    }
  }


})