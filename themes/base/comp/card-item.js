Vue.component("card-item", {
  data: function () {
    return {
      mutablelabel: this.label,
    };
  },
  props: {
    label: {
      default: 0,
      type: Number,
    },
    isfullinfo: {
      default: false,
      type: Boolean,
    },
    urltogo: {
      default: "NA",
      type: String,
    },
    url: {
      default: "NA",
      type: String,
    },
    isloading: {
      default: true,
      type: Boolean,
    },
    isfailed: {
      default: false,
      type: Boolean,
    },
  },
  methods: {
    onLoadAgain:function(){
      this.isloading = !this.isloading;
      this.loadData()
    },
    loadData: function () {
      fetch(this.url, {
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((response) => response.json())
        .then((data) => {
          this.isloading = !this.isloading;
          if (!this.isfullinfo) {
            //this.$emit('update:label', data.fullinfo)
            //this.$emit('update:label', data.dailyorder)
            this.label = data.dailyorder;
            //console.log("data.dailyorder", data.dailyorder);
          } else {
            this.label = data.fullinfo;
            console.log("!this.isfullinfo", data);
          }
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    },
  },
  template: `<button  class="btn btn-danger" v-if="!label && !isloading" @click="onLoadAgain"> <span >Load Again</span> </button> 
  <a v-else :href="urltogo"  target="_blank">
    
    <span v-if="isloading" class="spinner-border"></span>
    <span v-else>{{label}}</span>
    

 </a>`,
  async beforeMount() {
    this.loadData();
    //console.log("mutablelabel",this);
  },
});
