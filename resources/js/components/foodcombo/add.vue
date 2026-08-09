<template>
  <div>
    <h3 class="page-title">Thêm combo món ăn</h3>
    <div class="row">
      <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <crm-form-section title="Thông tin chính">
              <div class="form-group">
                <label>Tên combo</label>
                <vs-input
                  type="text"
                  size="default"
                  placeholder="Tên combo món ăn"
                  class="w-100"
                  v-model="objData.name"
                />
              </div>
              <div class="form-group">
                <label>Ảnh đại diện</label>
                <ImageMulti v-model="objData.images" :title="'combo-mon-an'" />
              </div>
              <div class="form-group">
                <label>Mô tả ngắn</label>
                <vs-textarea
                  v-model="objData.description"
                  placeholder="Mô tả ngắn về combo"
                />
              </div>
              <div class="form-group">
                <label>Menu</label>
                <TinyMce v-model="objData.menu" />
              </div>
              <div class="form-group">
                <label>Nội dung</label>
                <TinyMce v-model="objData.content" />
              </div>
            </crm-form-section>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <crm-form-section title="Giá & thiết lập">
              <div class="form-group">
                <label>Giá combo</label>
                <vs-input
                  type="number"
                  size="default"
                  placeholder="Giá gốc"
                  class="w-100"
                  v-model="objData.price"
                />
              </div>
              <div class="form-group">
                <label>Giá khuyến mãi</label>
                <vs-input
                  type="number"
                  size="default"
                  placeholder="Để trống nếu không KM"
                  class="w-100"
                  v-model="objData.sale_price"
                />
              </div>
              <div class="form-group">
                <label>Thứ tự</label>
                <vs-input
                  type="number"
                  size="default"
                  class="w-100"
                  v-model="objData.sort"
                />
              </div>
              <div class="form-group">
                <label>Trạng thái</label>
                <vs-select v-model="objData.status">
                  <vs-select-item value="1" text="Hiện" />
                  <vs-select-item value="0" text="Ẩn" />
                </vs-select>
              </div>
              <div class="form-group">
                <label>Hiển thị trang chủ</label>
                <vs-select v-model="objData.status_home">
                  <vs-select-item value="1" text="Có" />
                  <vs-select-item value="0" text="Không" />
                </vs-select>
              </div>
            </crm-form-section>
          </div>
        </div>
      </div>
    </div>
    <div class="row fixxed">
      <div class="col-12">
        <div class="saveButton">
          <vs-button color="primary" @click="saveCombo">Thêm mới</vs-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import TinyMce from "../_common/tinymce";
import ImageMulti from "../_common/upload_image_multi";

export default {
  name: "addFoodCombo",
  components: {
    TinyMce,
    ImageMulti,
  },
  data() {
    return {
      errors: [],
      objData: {
        name: "",
        images: [],
        description: "",
        menu: "",
        content: "",
        price: 0,
        sale_price: "",
        sort: 0,
        status: 1,
        status_home: 1,
      },
    };
  },
  methods: {
    ...mapActions(["addFoodCombo", "loadings"]),
    validate() {
      this.errors = [];
      if (!this.objData.name) this.errors.push("Tên combo không được để trống");
      if (!this.objData.images || !this.objData.images.length) {
        this.errors.push("Vui lòng chọn ít nhất 1 ảnh");
      }
      if (!this.objData.description) this.errors.push("Mô tả ngắn không được để trống");
      if (!this.objData.menu) this.errors.push("Menu không được để trống");
      if (this.objData.price === "" || this.objData.price === null) {
        this.errors.push("Giá combo không được để trống");
      }
      if (this.errors.length) {
        this.errors.forEach((msg) => this.$error(msg));
        return false;
      }
      return true;
    },
    saveCombo() {
      if (!this.validate()) return;
      this.loadings(true);
      this.addFoodCombo(this.objData)
        .then(() => {
          this.loadings(false);
          this.$success("Thêm combo thành công");
          this.$router.push({ name: "listFoodCombo" });
        })
        .catch(() => {
          this.loadings(false);
          this.$error("Thêm combo thất bại");
        });
    },
  },
};
</script>
