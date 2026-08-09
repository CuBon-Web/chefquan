<template>
  <div>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
              <h4 class="card-title mb-0">Quản lý đặt bàn / liên hệ</h4>
              <div class="d-flex flex-wrap align-items-center" style="gap:10px;">
                <vs-select
                  v-model="filterType"
                  placeholder="Loại"
                  style="min-width:160px;"
                  @change="listMessContacts"
                >
                  <vs-select-item value="all" text="Tất cả" />
                  <vs-select-item value="booking" text="Đặt bàn" />
                  <vs-select-item value="contact" text="Liên hệ" />
                </vs-select>
                <vs-input
                  icon="search"
                  placeholder="Tìm tên, SĐT, email..."
                  v-model="keyword"
                  @keyup="searchDebounce"
                />
              </div>
            </div>

            <vs-table max-items="20" pagination :data="list" stripe>
              <template slot="thead">
                <vs-th>ID</vs-th>
                <vs-th>Loại</vs-th>
                <vs-th>Khách hàng</vs-th>
                <vs-th>Ngày đặt</vs-th>
                <vs-th>Giờ</vs-th>
                <vs-th>Số khách</vs-th>
                <vs-th>Ghi chú</vs-th>
                <vs-th>Trạng thái</vs-th>
                <vs-th>Ngày gửi</vs-th>
              </template>
              <template slot-scope="{data}">
                <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                  <vs-td :data="tr.id">{{ tr.id }}</vs-td>
                  <vs-td :data="tr.type">
                    <span class="badge" :class="tr.type === 'booking' ? 'badge-warning' : 'badge-secondary'">
                      {{ typeLabel(tr.type) }}
                    </span>
                  </vs-td>
                  <vs-td :data="tr.name">
                    <div><strong>{{ tr.name || '—' }}</strong></div>
                    <div class="text-muted small">{{ tr.phone || '—' }}</div>
                    <div class="text-muted small">{{ tr.email || '—' }}</div>
                  </vs-td>
                  <vs-td :data="tr.booking_date">{{ formatDate(tr.booking_date) }}</vs-td>
                  <vs-td :data="tr.booking_time">{{ tr.booking_time || '—' }}</vs-td>
                  <vs-td :data="tr.guests">{{ tr.guests ? tr.guests + ' khách' : '—' }}</vs-td>
                  <vs-td :data="tr.mess">
                    <span class="mess-clamp" :title="tr.mess">{{ tr.mess || '—' }}</span>
                  </vs-td>
                  <vs-td :data="tr.status">
                    <select
                      class="form-control form-control-sm status-select"
                      :value="tr.status || 'new'"
                      @change="changeStatus(tr, $event.target.value)"
                    >
                      <option value="new">Mới</option>
                      <option value="confirmed">Đã xác nhận</option>
                      <option value="done">Hoàn tất</option>
                      <option value="cancelled">Hủy</option>
                    </select>
                  </vs-td>
                  <vs-td :data="tr.created_at">{{ formatDateTime(tr.created_at) }}</vs-td>
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
import { HTTP } from "../../core/plugins/http";

export default {
  data: () => ({
    keyword: "",
    filterType: "booking",
    list: [],
    timer: null,
  }),
  methods: {
    ...mapActions(["listMessContact", "loadings"]),
    typeLabel(type) {
      return type === "booking" ? "Đặt bàn" : "Liên hệ";
    },
    formatDate(value) {
      if (!value) return "—";
      const raw = String(value).slice(0, 10);
      const parts = raw.split("-");
      if (parts.length !== 3) return raw;
      return parts[2] + "/" + parts[1] + "/" + parts[0];
    },
    formatDateTime(value) {
      if (!value) return "—";
      const d = new Date(value);
      if (Number.isNaN(d.getTime())) return value;
      const pad = (n) => String(n).padStart(2, "0");
      return (
        pad(d.getDate()) +
        "/" +
        pad(d.getMonth() + 1) +
        "/" +
        d.getFullYear() +
        " " +
        pad(d.getHours()) +
        ":" +
        pad(d.getMinutes())
      );
    },
    searchDebounce() {
      clearTimeout(this.timer);
      this.timer = setTimeout(() => {
        this.listMessContacts();
      }, 350);
    },
    listMessContacts() {
      this.loadings(true);
      this.listMessContact({
        keyword: this.keyword,
        type: this.filterType === "all" ? "" : this.filterType,
      })
        .then((response) => {
          this.loadings(false);
          this.list = response.data || [];
        })
        .catch(() => {
          this.loadings(false);
          this.list = [];
        });
    },
    changeStatus(row, status) {
      const prev = row.status || "new";
      row.status = status;
      HTTP.post("/api/messcontact/update-status", {
        id: row.id,
        status: status,
      })
        .then(() => {
          this.$vs.notify({
            title: "Thành công",
            text: "Đã cập nhật trạng thái",
            color: "success",
          });
        })
        .catch(() => {
          row.status = prev;
          this.$vs.notify({
            title: "Lỗi",
            text: "Không cập nhật được trạng thái",
            color: "danger",
          });
        });
    },
  },
  mounted() {
    this.listMessContacts();
  },
};
</script>

<style scoped>
.mess-clamp {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  max-width: 220px;
  white-space: pre-wrap;
}
.status-select {
  min-width: 130px;
}
.badge-warning {
  background: #f0c987;
  color: #3c0202;
  padding: 4px 8px;
  border-radius: 999px;
  font-weight: 600;
}
.badge-secondary {
  background: #e9ecef;
  color: #495057;
  padding: 4px 8px;
  border-radius: 999px;
  font-weight: 600;
}
</style>
