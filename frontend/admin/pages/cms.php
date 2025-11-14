<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/cms.css">

<main class="main-content cms-page">
    <section class="section-header">
        <h2>Quản lý CMS</h2>
        <button class="btn-add" onclick="window.location.href='index.php?page=add_cms'">+ Thêm CMS</button>
    </section>

    <section class="table-section">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Loại nội dung</th>
                    <th>Tiêu đề</th>
                    <th>Thời gian cập nhật</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="cms-body">
                <tr><td colspan="5" style="text-align:center;">Đang tải dữ liệu...</td></tr>
            </tbody>
        </table>
    </section>
</main>

<!-- Toast -->
<div id="toast-container"></div>

<!-- Modal chỉnh sửa CMS -->
<div id="editCmsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeCmsModal()">&times;</span>
        <h3>Chỉnh sửa nội dung CMS</h3>

        <form id="editCmsForm">
            <input type="hidden" id="editPageId">

            <label for="editType">Loại đường dẫn:</label>
            <input type="text" id="editType" required>

            <label for="editTitle">Tiêu đề trang:</label>
            <input type="text" id="editTitle" required>

            <label for="editContent">Nội dung:</label>
            <textarea id="editContent" rows="6" required></textarea>

            <button type="submit">Lưu thay đổi</button>
        </form>
    </div>
</div>

<!-- Modal Xóa -->
<div id="deleteModal" class="modal hidden">
    <div class="modal-content">
        <h3>Xác nhận xóa</h3>
        <p>Bạn có chắc muốn xóa trang CMS này?</p>

        <div style="text-align:right; margin-top: 15px;">
            <button id="cancelDelete" class="btn">Hủy</button>
            <button id="confirmDelete" class="btn btn-delete">Xóa</button>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => loadCms());

// ------- Toast -------
function showToast(message, type = "info", duration = 3000) {
    const container = document.getElementById("toast-container");
    const toast = document.createElement("div");
    toast.className = "toast " + type;
    toast.textContent = message;

    const closeBtn = document.createElement("span");
    closeBtn.className = "close-toast";
    closeBtn.innerHTML = "&times;";
    closeBtn.onclick = () => {
        toast.classList.remove("show");
        setTimeout(() => container.removeChild(toast), 300);
    };

    toast.appendChild(closeBtn);
    container.appendChild(toast);

    setTimeout(() => toast.classList.add("show"), 50);
    setTimeout(() => {
        toast.classList.remove("show");
        setTimeout(() => container.removeChild(toast), 300);
    }, duration);
}

// ------- Load CMS -------
function loadCms() {
    fetch("http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_cms")
        .then(res => res.json())
        .then(response => {
            if (!response.success || !Array.isArray(response.data)) {
                throw new Error("API trả về dữ liệu sai");
            }

            let html = "";
            response.data.forEach(page => {
                html += `
                    <tr>
                        <td>${page.PAGE_ID}</td>
                        <td>${page.TYPE || ""}</td>
                        <td>${page.TITLE || ""}</td>
                        <td>${page.UPDATED_AT ? new Date(page.UPDATED_AT).toLocaleString("vi-VN") : ""}</td>
                        <td>
                            <button class="btn-edit" onclick="editPage('${page.PAGE_ID}')">Sửa</button>
                            <button class="btn-delete" onclick="deletePage('${page.PAGE_ID}')">Xóa</button>
                        </td>
                    </tr>
                `;
            });

            document.getElementById("cms-body").innerHTML = html;
        })
        .catch(error => {
            document.getElementById("cms-body").innerHTML =
                '<tr><td colspan="5" style="text-align:center;">Lỗi tải dữ liệu</td></tr>';
        });
}

// ------- Modal sửa -------
let selectedPageId = null;

function editPage(id) {
    selectedPageId = id;

    fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_page&id=${id}`)
        .then(res => res.json())
        .then(page => {
            document.getElementById("editPageId").value = page.PAGE_ID;
            document.getElementById("editType").value = page.TYPE || "";
            document.getElementById("editTitle").value = page.TITLE || "";
            document.getElementById("editContent").value = page.CONTENT || "";

            document.getElementById("editCmsModal").style.display = "flex";
        })
        .catch(() => showToast("Không thể tải dữ liệu trang CMS", "error"));
}

function closeCmsModal() {
    document.getElementById("editCmsModal").style.display = "none";
}

// Lưu sửa CMS
document.getElementById("editCmsForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const data = {
        PAGE_ID: document.getElementById("editPageId").value,
        TYPE: document.getElementById("editType").value,
        TITLE: document.getElementById("editTitle").value,
        CONTENT: document.getElementById("editContent").value
    };

    fetch("http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=cms&action=update_page", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    })
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                showToast("Cập nhật thành công!", "success");
                closeCmsModal();
                loadCms();
            } else {
                showToast("Lỗi cập nhật!", "error");
            }
        });
});

// ------- Xóa CMS -------
let deletePageId = null;

function deletePage(id) {
    deletePageId = id;
    document.getElementById("deleteModal").style.display = "flex";
}

document.getElementById("cancelDelete").onclick = () => {
    document.getElementById("deleteModal").style.display = "none";
};

document.getElementById("confirmDelete").onclick = () => {
    document.getElementById("deleteModal").style.display = "none";

    fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=delete_page&id=${deletePageId}`, {
        method: "DELETE"
    })
        .then(res => res.json())
        .then(result => {
            showToast(result.success ? "Xóa thành công!" : "Xóa thất bại!", result.success ? "success" : "error");
            loadCms();
        });
};
</script>
