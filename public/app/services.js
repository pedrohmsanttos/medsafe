'use strict';

angular.module('MedSafer')

    .factory('Service', ['$http', function($http){

        var token = "";
        
        // pegando o token para efetuar as solicitações pelo servidor...
        var config = {headers:  {
            'X-Auth-Token': token //window.sessionStorage.getItem('token')
            }
        };
        var anonimoConfig = {headers: {
            'X-Auth-Token': "IS_AUTHENTICATED_ANONYMOUSLY"
            }
        }
        // todas as requisições são feita por aqui (post, get, put, delete)...
        return {
            tabelaDePreco: function(params, then) {
                $http.get('/api/v1/tabelapreco?search=' + params + '&searchFields=produto_id:=;categoria_produto_id:=;tipo_produto_id:=;&searchJoin=and', config).then(then)
            }
        };
    }])
