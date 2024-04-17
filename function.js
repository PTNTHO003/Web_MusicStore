const filterCheckboxes = document.querySelectorAll('.filter-checkbox');

filterCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('click', function () {
        // Lấy giá trị của thuộc tính data-filter của checkbox
        const filterType = this.dataset.filter;

        // Tìm tất cả các checkbox được chọn
        const checkedFilters = document.querySelectorAll('.filter-checkbox:checked');

        // Lọc các sản phẩm dựa trên các tiêu chí được chọn
        filterProducts(checkedFilters);
    });
});

// Hàm lọc sản phẩm dựa trên các tiêu chí được chọn
function filterProducts(checkedFilters) {
    // Viết mã để lọc các sản phẩm dựa trên các tiêu chí được chọn
    // Lấy danh sách các sản phẩm từ server hoặc từ một nguồn dữ liệu khác
    // Sau đó, hiển thị các sản phẩm phù hợp trong danh sách sản phẩm
}


document.addEventListener("DOMContentLoaded", function () {
    // Lấy thẻ button "Apply Filter"
    var applyFilterBtn = document.getElementById("apply-price-filter");

    // Thêm sự kiện click cho button "Apply Filter"
    applyFilterBtn.addEventListener("click", function () {
        var minPrice = document.getElementById("min-price").value;
        var maxPrice = document.getElementById("max-price").value;

        apply_price_filter(minPrice, maxPrice);
    });
});

// Hàm áp dụng bộ lọc
function apply_price_filter(minPrice, maxPrice) {
    // Lặp qua danh sách các sản phẩm và ẩn hoặc hiển thị tùy thuộc vào giá trị giữa minPrice và maxPrice
    var productItems = document.querySelectorAll(".product-item");
    productItems.forEach(function (item) {
        var productItems = document.querySelectorAll(".product-item");
        productItems.forEach(function (item) {
            var priceElement = item.querySelector(".product-price"); 
            var priceText = priceElement.textContent.trim();
            var price = parseFloat(priceText.replace("$", "")); 
            if (!isNaN(price) && price >= minPrice && price <= maxPrice) {
                item.style.display = "block"; // Hiển thị sản phẩm nếu nằm trong khoảng giá
            } else {
                item.style.display = "none"; // Ẩn sản phẩm nếu không nằm trong khoảng giá hoặc giá không hợp lệ
            }
        });
    });
}

