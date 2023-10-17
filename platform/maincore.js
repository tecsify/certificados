
new Vue({
    el: '#app',
    data () {
        axios
        .get('https://tecsify.com/blog/wp-json/wp/v2/posts',{
            params: {
                per_page: 6
             }
          })
        .then(response => (this.info = response.data))

      return {
        info: this.info,

      }
    },

  });

  new Vue({
    el: '#app2',
    data () {
        axios
        .get('https://tecsify.com/blog/wp-json/wp/v2/codigo',{
            params: {
                per_page: 2
             }
          })
        .then(response => (this.codigos = response.data))

      return {
        codigos: this.codigos,

      }
    },

  });


  
  new Vue({
    el: '#app3',
    data () {
        axios
        .get('https://tecsify.com/blog/wp-json/wp/v2/infografia',{
            params: {
                per_page: 2
             }
          })
        .then(response => (this.infografias = response.data))

      return {
        infografias: this.infografias,

      }
    },

  });