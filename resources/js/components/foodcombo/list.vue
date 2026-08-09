<template>
  <div>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Danh sách combo món ăn</h4>
            <vs-button
              type="gradient"
              style="float:right;"
              :disabled="!$hasPermission('foodcombo.create')"
              @click="$goIfAllowed('foodcombo.create', { name: 'addFoodCombo' }, 'Bạn không có quyền thêm combo.')"
            >Thêm mới</vs-button>
            <vs-input icon="search" placeholder="Tìm combo..." v-model="keyword" @keyup="searchCombo" />
            <vs-table stripe :data="list" max-items="10" pagination>
              <template slot="thead">
                <vs-th>Ảnh</vs-th>
                <vs-th>Tên</vs-th>
                <vs-th>Giá</vs-th>
                <vs-th>Trạng thái</vs-th>
                <vs-th>Hành động</vs-th>
              </template>
              <template slot-scope="{data}">
                <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                  <vs-td :data="tr.id">
                    <vs-avatar size="70px" :src="coverImage(tr)" />
                  </vs-td>
                  <vs-td :data="tr.name">{{ tr.name }}</vs-td>
                  <vs-td>
                    <span v-if="tr.sale_price && Number(tr.sale_price) > 0">
                      <del class="text-muted">{{ formatPrice(tr.price) }}</del>
                      <strong class="ml-1">{{ formatPrice(tr.sale_price) }}</strong>
                    </span>
                    <strong v-else>{{ formatPrice(tr.price) }}</strong>
                  </vs-td>
                  <vs-td>
                    <span v-if="Number(tr.status) === 1">Hiện</span>
                    <span v-else>Ẩn</span>
                  </vs-td>
                  <vs-td>
                    <router-link :to="{ name: 'editFoodCombo', params: { id: tr.id } }">
                      <vs-button vs-type="gradient" size="lagre" color="success" icon="edit"></vs-button>
                    </router-link>
                    <vs-button
                      vs-type="gradient"
                      size="lagre"
                      color="red"
                      icon="delete_forever"
                      @click="confirmDestroy(tr.id)"
                    ></vs-button>
                  </vs-td>
                </vs-tr>
              </template>
            </vs-table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  data() {
    return {
      list: [],
      keyword: "",
      id_item: "",
      timer: null,
    };
  },
  methods: {
    ...mapActions(["listFoodCombo", "loadings", "deleteFoodCombo"]),
    coverImage(item) {
      if (!item || !item.images) return "";
      if (Array.isArray(item.images)) return item.images[0] || "";
      try {
        const arr = JSON.parse(item.images);
        return Array.isArray(arr) && arr.length ? arr[0] : "";
      } catch (e) {
        return "";
      }
    },
    formatPrice(value) {
      const num = Number(value || 0);
      return num.toLocaleString("vi-VN") + "đ";
    },
    listCombos() {
      this.loadings(true);
      this.listFoodCombo({ keyword: this.keyword })
        .then((response) => {
          this.loadings(false);
          this.list = response.data || [];
        })
        .catch(() => {
          this.loadings(false);
          this.list = [];
        });
    },
    confirmDestroy(id) {
      this.id_item = id;
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Bạn có chắc chắn",
        text: "Xóa combo này?",
        accept: this.destroy,
      });
    },
    searchCombo() {
      if (this.timer) {
        clearTimeout(this.timer);
        this.timer = null;
      }
      this.timer = setTimeout(() => {
        this.listCombos();
      }, 800);
    },
    destroy() {
      this.deleteFoodCombo({ id: this.id_item }).then(() => {
        this.listCombos();
        this.loadings(false);
        this.$success("Xóa thành công");
      });
    },
  },
  mounted() {
    this.listCombos();
  },
};
</script>
