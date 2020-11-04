// 数値を通貨書式「#,###,###」に変換するフィルター
Vue.filter('number_format', function(val) {
  return val.toLocaleString();
});
// 商品一覧コンポーネント
var app = new Vue({
  el: '#app',
  data: {
    //「並び替え」の選択値（1：標準、2：価格が安い順）
    sortOrder: 1,
    // 商品リスト
    products: [
      { item_id: 1, item_name: 'Black Bandana', price: 2500, image: 'images/BlackBandana.jpg' },
      { item_id: 2, item_name: '"LUMIN" Body Care Set', price: 15000, image: 'images/BlackBodyCareSet.jpg' },
      { item_id: 3, item_name: 'Black Gradation Sunglasses', price: 30000, image: 'images/BlackSunglasses.jpg' },
      { item_id: 4, item_name: 'Mat All Black Road Bike', price: 69800, image: 'images/MatAllBlackRoadBike.jpg' },
      { item_id: 5, item_name: 'White Wrist Watch', price: 35000, image: 'images/WhiteWatch.jpg' },
      { item_id: 6, item_name: '"ONNE" Body Care Set', price: 7500, image: 'images/WhiteBodyCareSet.jpg' },
      { item_id: 7, item_name: 'White Electric Kettle', price: 7980, image: 'images/WhiteElectricKettle.jpg' },
      { item_id: 8, item_name: 'White Tea Cup Set', price: 3000, image: 'images/WhiteTeaCupSet_01.jpg' },
      { item_id: 9, item_name: 'Gray Tea Cup', price: 1500, image: 'images/GrayCup.jpg' },
      { item_id: 10, item_name: 'Gray Kicks', price: 45000, image: 'images/GrayKicks.jpg' },
      { item_id: 11, item_name: '"The Ordinary" Cleanz Clay', price: 2500, image: 'images/GrayFaceCare.jpg' },
      { item_id: 12, item_name: 'Bluetooth Pocket Speaker', price: 5000, image: 'images/GraySpeaker.jpg' },
    ]
  },
  computed: {
    // 絞り込み後の商品リストを返す算出プロパティ
    filteredList: function() {
      // 絞り込み後の商品リストを格納する新しい配列
      var newList = [];
      for (var i = 0; i < this.products.length; i++) {
        // 表示対象かどうかを判定するフラグ
        var isShow = true;
        // 表示対象の商品だけを新しい配列に追加する
        if (isShow) {
          newList.push(this.products[i]);
        }
      }
      // 新しい配列を並び替える
      if (this.sortOrder == 1) {
        // 元の順番にpushしているので並び替え済み
      }
      else if (this.sortOrder == 2) {
        // 価格が安い順に並び替える
        newList.sort(function(a,b) {
          return a.price - b.price;
        });
      }
      // 絞り込み後の商品リストを返す
      return newList;
    }
  }
});
