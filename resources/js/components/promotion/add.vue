<template>
  <div>
      <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label>Tiêu đề khuyến mãi</label>
                <vs-input
                  type="text"
                  size="default"
                  placeholder="Tên bài viết"
                  class="w-100"
                  v-model="objData.name"
                />
              </div>
              <div class="form-group">
                <label>Mô tả ngắn</label>
                <vs-input
                  type="text"
                  size="default"
                  placeholder="Tên bài viết"
                  class="w-100"
                  v-model="objData.description"
                />
              </div>
              <div class="form-group">
                <label>Nội dung</label>
                <TinyMce
                  v-model="objData.content"
                />
              </div>
              <div class="form-group">
                <label>Ảnh đại diện</label>
                <image-upload v-model="objData.image" type="avatar" :title="'khuyen-mai-'"></image-upload>
              </div>
            </div>
            
          </div>
          
        </div>
        <div class="col-md-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label>Trạng thái</label>
                <vs-select v-model="objData.status"
                  >
                      <vs-select-item  value="1" text="Hiện" />
                      <vs-select-item  value="0" text="Ẩn" />
                    </vs-select>
              </div>
              <div class="form-group">
                <label>Nhãn nổi bật</label>
                <vs-input
                  type="text"
                  size="default"
                  placeholder="VD: -15%, Tặng rượu vang"
                  class="w-100"
                  v-model="objData.badge"
                />
              </div>
              <div class="form-group">
                <label>Ngày bắt đầu</label>
                <vs-input type="date" class="w-100" v-model="objData.start_date" />
              </div>
              <div class="form-group">
                <label>Ngày kết thúc</label>
                <vs-input type="date" class="w-100" v-model="objData.end_date" />
              </div>
              <div class="form-group">
                <label>Link ngoài (tùy chọn)</label>
                <vs-input
                  type="text"
                  size="default"
                  placeholder="https://..."
                  class="w-100"
                  v-model="objData.link"
                />
              </div>
            </div>
          </div>
          
        </div>
        
      </div>
      <div class="row fixxed">
        <div class="col-12">
          <div class="saveButton">
            <vs-button color="primary" @click="addPromotions">Thêm mới</vs-button>
          </div>
        </div>
      </div>
    <!-- content-wrapper ends -->
  </div>
</template>


<script>
import { mapActions } from "vuex";
import TinyMce from "../_common/tinymce";
export default {
  name: "product",
  data() {
    return {
      errors:[],
      cate:[],
      lang:[],
      showLang:{
        title:false,
        content:false,
        description:false
      },
      objData: {
        name: '',
        description: '',
        status: 1,
        image: "",
        content:"",
        link: "",
        badge: "",
        start_date: "",
        end_date: ""
      }
    };
  },
  components: {
    TinyMce
  },
  computed: {},
  watch: {},
  methods: {
    ...mapActions(["addPromotion", "loadings"]),
    addPromotions(){
      this.errors = [];
      if(this.objData.name == '') this.errors.push('Tên không được để trống');
      if(this.objData.description == '') this.errors.push('Mô tả không được để trống');
      if(this.objData.content == '') this.errors.push('Nội dung không được để trống');
      if(this.objData.image == '') this.errors.push('Vui lòng chọn ảnh');
      if(this.objData.start_date && this.objData.end_date && this.objData.end_date < this.objData.start_date) this.errors.push('Ngày kết thúc phải sau ngày bắt đầu');
      if (this.errors.length > 0) {
        this.errors.forEach((value, key) => {
          this.$error(value)
        })
        return;
      }else{
        this.loadings(true);
        this.addPromotion(this.objData).then(response => {
          this.loadings(false);
          this.$router.push({name:'listPromotion'});
          this.$success('Thêm khuyến mãi thành công');
        }).catch(error => {
          this.loadings(false);
          this.$error('Thêm khuyến mãi thất bại');
        })
      }
    },
  },
  mounted() {
  }
};
</script>