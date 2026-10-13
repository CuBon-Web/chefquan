<template>
  <div>
    <h3 class="page-title">Banner trang Taste Of Vietnam</h3>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="text-muted mb-4">
              Mỗi banner là một slide ở đầu trang Taste Of Vietnam. Thứ tự hiển thị theo thứ tự trong danh sách này.
            </p>

            <div
              class="row tov-banner-row"
              v-for="(item, key) in objData"
              :key="'tov-banner-' + key"
            >
              <div class="col-md-12 mb-3 d-flex align-items-center justify-content-between">
                <strong>Slide #{{ key + 1 }}</strong>
                <div class="d-flex align-items-center tov-banner-row__actions">
                  <label
                    v-if="key > 0"
                    title="Đưa lên"
                    @click="moveObjBanner(key, -1)"
                  >
                    <vs-icon icon="arrow_upward"></vs-icon>
                  </label>
                  <label
                    v-if="key < objData.length - 1"
                    title="Đưa xuống"
                    @click="moveObjBanner(key, 1)"
                  >
                    <vs-icon icon="arrow_downward"></vs-icon>
                  </label>
                  <label
                    v-if="objData.length > 1"
                    title="Xóa slide"
                    @click="removeObjBanner(key)"
                  >
                    <vs-icon icon="clear"></vs-icon>
                  </label>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Ảnh Desktop <span class="text-danger">*</span></label>
                  <image-upload
                    type="avatar"
                    v-model="item.image"
                    :title="'banner-taste-of-vietnam'"
                  ></image-upload>
                </div>
                <div class="form-group">
                  <label>Ảnh Mobile</label>
                  <p class="text-muted small mb-2">Bỏ trống sẽ dùng ảnh Desktop.</p>
                  <image-upload
                    type="avatar"
                    v-model="item.image_mobile"
                    :title="'banner-taste-of-vietnam'"
                  ></image-upload>
                </div>
              </div>

              <div class="col-md-9">
                <div class="form-group">
                  <label>Dòng chữ nhỏ phía trên tiêu đề</label>
                  <vs-input
                    type="text"
                    v-model="item.eyebrow"
                    placeholder="Nhà hàng ẩm thực Việt"
                    class="w-100"
                  />
                </div>
                <div class="form-group">
                  <label>Tiêu đề</label>
                  <vs-input
                    type="text"
                    v-model="item.title"
                    placeholder="Không gian trải nghiệm ẩm thực Chef Quân Signature"
                    class="w-100"
                  />
                </div>
                <div class="form-group">
                  <label>Mô tả</label>
                  <vs-textarea
                    v-model="item.description"
                    placeholder="Tinh hoa ẩm thực Việt được thăng hoa qua bàn tay của Chef Quân..."
                    height="90px"
                    class="w-100"
                  />
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Chữ trên nút chính</label>
                      <vs-input
                        type="text"
                        v-model="item.button_text"
                        placeholder="Đặt bàn ngay"
                        class="w-100"
                      />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Link nút chính</label>
                      <vs-input
                        type="text"
                        v-model="item.button_link"
                        placeholder="Bỏ trống để mở form đặt bàn"
                        class="w-100"
                      />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Chữ cạnh nút video</label>
                      <vs-input
                        type="text"
                        v-model="item.video_text"
                        placeholder="Khám phá nhà hàng"
                        class="w-100"
                      />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Link video (YouTube)</label>
                      <vs-input
                        type="text"
                        v-model="item.video_link"
                        placeholder="Bỏ trống để ẩn nút video"
                        class="w-100"
                      />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Trạng thái</label>
                  <vs-select v-model="item.status">
                    <vs-select-item value="1" text="Hiện" />
                    <vs-select-item value="0" text="Ẩn" />
                  </vs-select>
                </div>
              </div>

              <hr style="border: 0.5px solid #04040426; width: 100%; margin: 24px 0" />
            </div>

            <vs-button color="primary" @click="saveBanners">Lưu</vs-button>
            <vs-button color="success" @click="addObjBanner">Thêm slide</vs-button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";

const defaultBanner = () => ({
  image: "",
  image_mobile: "",
  eyebrow: "",
  title: "",
  description: "",
  button_text: "",
  button_link: "",
  video_text: "",
  video_link: "",
  status: "1",
});

export default {
  name: "tovBanner",
  data() {
    return {
      objData: [defaultBanner()],
    };
  },
  methods: {
    ...mapActions(["saveTovBanner", "listTovBanner", "loadings"]),
    normalizeBanner(item) {
      const row = { ...defaultBanner() };
      Object.keys(row).forEach((field) => {
        if (item[field] !== undefined && item[field] !== null) {
          row[field] = item[field];
        }
      });
      row.status = String(row.status);
      return row;
    },
    validateBanners() {
      for (let i = 0; i < this.objData.length; i++) {
        if (!this.objData[i].image) {
          this.$error(`Slide #${i + 1}: Vui lòng tải ảnh Desktop.`);
          return false;
        }
      }
      return true;
    },
    saveBanners() {
      if (!this.validateBanners()) return;

      this.loadings(true);
      this.saveTovBanner({ data: this.objData })
        .then(() => {
          this.loadings(false);
          this.$success("Lưu banner thành công");
          this.loadBanners();
        })
        .catch(() => {
          this.loadings(false);
          this.$error("Lưu banner thất bại");
        });
    },
    addObjBanner() {
      this.objData.push(defaultBanner());
    },
    removeObjBanner(i) {
      this.objData.splice(i, 1);
    },
    moveObjBanner(i, step) {
      const target = i + step;
      if (target < 0 || target >= this.objData.length) return;
      const rows = this.objData.slice();
      [rows[i], rows[target]] = [rows[target], rows[i]];
      this.objData = rows;
    },
    loadBanners() {
      this.loadings(true);
      this.listTovBanner()
        .then((response) => {
          this.loadings(false);
          const rows = response.data || [];
          this.objData = rows.length
            ? rows.map((row) => this.normalizeBanner(row))
            : [defaultBanner()];
        })
        .catch(() => {
          this.loadings(false);
        });
    },
  },
  mounted() {
    this.loadBanners();
  },
};
</script>

<style scoped>
.tov-banner-row {
  margin-bottom: 8px;
}

.tov-banner-row__actions label {
  margin: 0 0 0 8px;
  cursor: pointer;
}
</style>
