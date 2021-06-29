<div class="banner">
    <div class="container">
        <div class="banner-wrap">
            <h1>Cập nhật kiến thức về COVID19</h1>
            <p>Xây dựng và củng cố kiến thức cùng các chuyên gia hàng đầu tâm huyết với giá <span class="vj-color">chỉ từ 299k</span>.</p>
        </div>
        <div class="main-search">
            <form method="get" action="{{ route('front.home.search') }}">
                <label>
                    <select class="search-select" name="type">
                        <option value="normal">Khóa đào tạo</option>
                        <option value="test">Trắc nghiệm</option>
                    </select>
                    <i class="far fa-chevron-down"></i>
                </label>
                <input type="text" class="search-input" placeholder="Nhập từ khóa..." name="q"/>
                <button class="btn-link"><i class="fal fa-search"></i></button>
            </form>
        </div>
    </div>
</div>
<!--banner-->