<template>
  <div
    class="cq-image-upload"
    :class="[
      'cq-image-upload--' + type,
      {
        'is-filled': !!previewUrl,
        'is-loading': loading,
      },
    ]"
    :style="rootStyle"
    v-loading="loading"
  >
    <el-upload
      class="cq-image-upload__uploader"
      action="/upload"
      name="img"
      :http-request="request"
      :before-upload="beforeUpload"
      :on-remove="handleRemove"
      :show-file-list="false"
      :file-list="fileList"
      accept="image/jpeg,image/png,image/webp,.jpg,.jpeg,.png,.webp"
    >
      <div class="cq-image-upload__frame">
        <img
          v-if="previewUrl"
          class="cq-image-upload__img"
          :src="previewUrl"
          alt="Preview"
        />
        <div v-else class="cq-image-upload__placeholder">
          <span class="cq-image-upload__icon">
            <i class="el-icon-plus"></i>
          </span>
          <span class="cq-image-upload__text">Tải ảnh lên</span>
          <span class="cq-image-upload__hint">JPG, PNG, WebP</span>
        </div>
        <div v-if="previewUrl" class="cq-image-upload__overlay">
          <i class="el-icon-refresh-right"></i>
          <span>Đổi ảnh</span>
        </div>
      </div>
    </el-upload>
  </div>
</template>

<script>
import imageCompression from "browser-image-compression";

export default {
  props: {
    value: {
      type: String,
    },
    type: {
      type: String,
      default: "avatar-img",
    },
    height: {
      type: String,
      default: "200px",
    },
    maxWidthHeight: {
      type: Number,
      default: 1000,
    },
    title: "",
  },
  data() {
    return {
      imageUrl: "",
      loading: false,
    };
  },
  computed: {
    previewUrl() {
      return this.imageUrl || this.value || "";
    },
    fileList() {
      if (!this.value) return [];
      return [{ name: this.value, url: this.value }];
    },
    rootStyle() {
      if (this.type === "avatar") {
        return {
          width: "200px",
          height: "200px",
        };
      }
      return {
        width: "100%",
        height: this.height,
      };
    },
  },
  watch: {
    value(val) {
      if (!val) {
        this.imageUrl = "";
      }
    },
  },
  methods: {
    handleRemove() {
      this.imageUrl = "";
      this.$emit("input", null);
    },
    getslugname(text) {
      var slug = "";
      var titleLower = (text || "").toLowerCase();
      slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, "e");
      slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, "a");
      slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, "o");
      slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, "u");
      slug = slug.replace(/đ/gi, "d");
      slug = slug.replace(/\s*$/g, "");
      slug = slug.replace(/\s+/g, "-");
      return slug;
    },
    isAllowedImageFile(file) {
      const allowedTypes = [
        "image/jpeg",
        "image/png",
        "image/webp",
        "image/jpg",
      ];
      if (file.type && allowedTypes.includes(file.type)) {
        return true;
      }
      const ext = (file.name || "").split(".").pop().toLowerCase();
      return ["jpg", "jpeg", "png", "webp"].includes(ext);
    },
    getCompressionOptions(file) {
      const options = {
        maxSizeMB: 3,
        maxWidthOrHeight: 10000,
        useWebWorker: file.type !== "image/webp",
        maxIteration: 10,
      };
      if (file.type === "image/webp") {
        options.fileType = "image/webp";
      } else if (file.type === "image/png") {
        options.fileType = "image/png";
      }
      return options;
    },
    beforeUpload(file) {
      if (!this.isAllowedImageFile(file)) {
        this.$message.error("Chỉ chấp nhận ảnh JPG, PNG hoặc WebP.");
        return false;
      }
      return true;
    },
    request(req) {
      const compress = imageCompression(
        req.file,
        this.getCompressionOptions(req.file)
      ).catch(() => req.file);
      compress.then((res) => {
        this.loading = true;
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open("POST", __ENV__.link + "api/upload-image");
        xhr.onload = () => {
          var json;
          if (xhr.status != 200) {
            this.$notify.error({
              message: "HTTP Error: " + xhr.status,
              type: "success",
            });
            this.loading = false;
            return;
          }
          json = JSON.parse(xhr.responseText);
          this.imageUrl = URL.createObjectURL(res);
          this.loading = false;
          return this.$emit("input", json.path.replace(__ENV__.link, "/"));
        };
        formData = new FormData();
        formData.append("img", res, req.file.name);
        formData.append("title_post", this.getslugname(this.title));
        xhr.send(formData);
      });
    },
  },
  created() {
    this.imageUrl = this.value;
  },
};
</script>

<style scoped>
.cq-image-upload {
  --cq-upload-border: #d8dee9;
  --cq-upload-border-hover: #409eff;
  --cq-upload-bg: #f7f9fc;
  --cq-upload-bg-hover: #eef5ff;
  --cq-upload-text: #606266;
  --cq-upload-muted: #909399;
  --cq-upload-radius: 10px;
  --cq-upload-overlay: rgba(15, 23, 42, 0.52);

  position: relative;
  display: block;
  width: 100%;
  max-width: 100%;
  box-sizing: border-box;
}

.cq-image-upload *,
.cq-image-upload *::before,
.cq-image-upload *::after {
  box-sizing: border-box;
}

.cq-image-upload >>> .el-upload {
  display: block;
  width: 100%;
  height: 100%;
  border: 1px dashed var(--cq-upload-border);
  border-radius: var(--cq-upload-radius);
  background: var(--cq-upload-bg);
  cursor: pointer;
  overflow: hidden;
  transition: border-color 0.25s ease, background-color 0.25s ease,
    box-shadow 0.25s ease;
}

.cq-image-upload >>> .el-upload:hover {
  border-color: var(--cq-upload-border-hover);
  background: var(--cq-upload-bg-hover);
  box-shadow: 0 0 0 3px rgba(64, 158, 255, 0.12);
}

.cq-image-upload.is-filled >>> .el-upload {
  background: #fff;
  border-style: solid;
}

.cq-image-upload.is-loading >>> .el-upload {
  pointer-events: none;
}

.cq-image-upload__uploader {
  width: 100%;
  height: 100%;
}

.cq-image-upload__frame {
  position: relative;
  width: 100%;
  height: 100%;
  min-height: inherit;
  display: flex;
  align-items: center;
  justify-content: center;
}

.cq-image-upload__img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.cq-image-upload__placeholder {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 6px;
  padding: 12px;
  width: 100%;
  height: 100%;
  color: var(--cq-upload-text);
  user-select: none;
}

.cq-image-upload__icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: #fff;
  border: 1px solid #e4e7ed;
  color: #409eff;
  font-size: 18px;
  box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
}

.cq-image-upload__text {
  font-size: 13px;
  font-weight: 600;
  line-height: 1.2;
}

.cq-image-upload__hint {
  font-size: 11px;
  color: var(--cq-upload-muted);
  line-height: 1.2;
}

.cq-image-upload__overlay {
  position: absolute;
  inset: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 6px;
  color: #fff;
  background: var(--cq-upload-overlay);
  opacity: 0;
  transition: opacity 0.25s ease;
  font-size: 13px;
  font-weight: 600;
}

.cq-image-upload__overlay i {
  font-size: 20px;
}

.cq-image-upload.is-filled >>> .el-upload:hover .cq-image-upload__overlay {
  opacity: 1;
}

/* Square preset used across admin forms */
.cq-image-upload--avatar {
  width: 200px;
  height: 200px;
}

.cq-image-upload--avatar .cq-image-upload__hint {
  display: none;
}

/* Fluid preset for wide banners / cards */
.cq-image-upload--avatar-img {
  width: 100%;
}
</style>
