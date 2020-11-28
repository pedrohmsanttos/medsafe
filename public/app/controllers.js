'use strict';

angular.module('MedSafer')
    
  .controller('Negocio',['$scope', 'Service', 'ngCart', '$window',function($scope, Service, ngCart, $window) {
    
    $scope.ngCart = ngCart;
    $scope.quantidade = 1;

    $scope.clearCart = function(){
      console.log(ngCart.getCart().items);
      ngCart.getCart().items.forEach((element, index) => {
        ngCart.removeItemById(element.getId());
        ngCart.removeItemById(index);
      });
      for (var i = 0; i < ngCart.getCart().items.length; i++) {
        ngCart.removeItemById(ngCart.getCart().items[i].getId());
      }
      console.log(ngCart.getCart().items);
      $scope.ngCart = ngCart;
    }

    $scope.getTabelaDePreco = function(){
      var produto     = document.getElementById('produto_id');
      var categoria   = document.getElementById('categoria_produto_id');
      var tipo        = document.getElementById('tipo_produto_id');

      var selectProduto = document.querySelector('#produto_id');
      selectProduto.addEventListener('change', async function() {
        var option = this.selectedOptions[0];
        $scope.tituloProduto = option.textContent;
        console.log($scope.tituloProduto);
        $scope.titulo = $scope.tituloProduto + ' - '+$scope.tituloCategoria +' ['+$scope.tituloTipo+' ]';
      });

      var selectCategoria = document.querySelector('#categoria_produto_id');
      selectCategoria.addEventListener('change', async function() {
        var option = this.selectedOptions[0];
        $scope.tituloCategoria = option.textContent;
        console.log($scope.tituloCategoria);
        $scope.titulo = $scope.tituloProduto + ' - '+$scope.tituloCategoria +' ['+$scope.tituloTipo+' ]';
      });

      var selectTipoProduto = document.querySelector('#tipo_produto_id');
      selectTipoProduto.addEventListener('change', async function() {
        var option = this.selectedOptions[0];
        $scope.tituloTipo = option.textContent;
        console.log($scope.tituloTipo);
        $scope.titulo = $scope.tituloProduto + ' - '+$scope.tituloCategoria +' ['+$scope.tituloTipo+' ]';
      });

      if(produto.value != 0 && produto.value != undefined &&
        categoria.value != 0 && categoria.value != undefined &&
        tipo.value != 0 && tipo.value != undefined){
          var params = 'produto_id:'+produto.value+';'+'categoria_produto_id:'+categoria.value+';'+'tipo_produto_id:'+tipo.value+';';
          $('.page-loader-wrapper').fadeIn();
          Service.tabelaDePreco(params, function(res) {
            $scope.list = res.data.data;
            console.log($scope.list.length === 0);
          }, function() {
              $scope.error = 'Não há tabela de preço cadastrada para a combinação selecionada!';
          })
          $('.page-loader-wrapper').fadeOut();
      }
    }

    
  }])

  .controller('Checkout',['$scope',function($scope) {

    $scope.loadDesconto = function(){
      $scope.desconto = $scope.valor_desconto.replace('R$', '').replace('.','').replace(',','.');
    }

    $scope.getValue = function(){

    }

    $scope.getNumber = function(init,end) {
      var temArr = [];
      var i = 0;
      init = Math.round(init);
      end  = Math.round(end);
      console.log(end +' '+init);
      for (var index = init; index < end; index++) {
        temArr[i] = index+1;
        i++;
      }
      console.log(temArr);
      return temArr;  
  }

  }])
