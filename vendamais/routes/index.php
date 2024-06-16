<?php

use function src\slimConfiguration;
use function src\basicAuth;

use App\Controllers\ClienteController;
use App\Controllers\ProdutoController;
use App\Controllers\FormaPgController;
use App\Controllers\SituacaoVendaController;
use App\Controllers\VendaController;
use App\Controllers\VendaItemController;
use App\Controllers\UsuarioController;
use App\Middlewares\CorsMiddleware;


$app = new \Slim\App(slimConfiguration());

$app->add(new CorsMiddleware());

// =========================================Login

$app->get('/login', '\App\Controllers\UsuarioController:tryLogin')->add(basicAuth());


/* =========================================Cliente com BasicAuth (para usar futuramente)
// BasicAuth já está funcionando com usuarios do banco

$app->group('', function() use ($app) {
    $app->get('/cliente', '\App\Controllers\ClienteController:getCliente');
    $app->post('/cliente', '\App\Controllers\ClienteController:insertCliente');
    $app->put('/cliente', '\App\Controllers\ClienteController:updateCliente');
    $app->delete('/cliente', '\App\Controllers\ClienteController:deleteCliente');
})->add(basicAuth());
*/
$app->group('', function() use ($app) {
// =========================================Cliente

    $app->get('/cliente', '\App\Controllers\ClienteController:getCliente');
    $app->post('/cliente', '\App\Controllers\ClienteController:insertCliente');
    $app->put('/cliente', '\App\Controllers\ClienteController:updateCliente');
    $app->delete('/cliente', '\App\Controllers\ClienteController:deleteCliente');

    // =========================================Produto

    $app->get('/produto', '\App\Controllers\ProdutoController:getProduto');
    $app->post('/produto', '\App\Controllers\ProdutoController:insertProduto');
    $app->put('/produto', '\App\Controllers\ProdutoController:updateProduto');
    $app->delete('/produto', '\App\Controllers\ProdutoController:deleteProduto');

    // =========================================Forma Pagamento

    $app->get('/formapg', '\App\Controllers\FormaPgController:getFormaPg');
    $app->post('/formapg', '\App\Controllers\FormaPgController:insertFormaPg');
    $app->put('/formapg', '\App\Controllers\FormaPgController:updateFormaPg');
    $app->delete('/formapg', '\App\Controllers\FormaPgController:deleteFormaPg');

    // =========================================Situacao venda

    $app->get('/situacaovd', '\App\Controllers\SituacaoVendaController:getSituacaoVenda');
    $app->post('/situacaovd', '\App\Controllers\SituacaoVendaController:insertSituacaoVenda');
    $app->put('/situacaovd', '\App\Controllers\SituacaoVendaController:updateSituacaoVenda');
    $app->delete('/situacaovd', '\App\Controllers\SituacaoVendaController:deleteSituacaoVenda');

    // =========================================Venda

    $app->get('/venda', '\App\Controllers\VendaController:getVenda');
    $app->post('/venda', '\App\Controllers\VendaController:insertVenda');
    $app->put('/venda', '\App\Controllers\VendaController:updateVenda');
    $app->delete('/venda', '\App\Controllers\VendaController:deleteVenda');
    $app->get('/venda/{id}', '\App\Controllers\VendaController:getVendaUnica');

    // =========================================Venda item

    $app->get('/vendaitem', '\App\Controllers\VendaItemController:getVendaItem');
    $app->post('/vendaitem', '\App\Controllers\VendaItemController:insertVendaItem');
    $app->post('/faturar', '\App\Controllers\VendaItemController:faturarVenda');
    $app->post('/cancelar', '\App\Controllers\VendaItemController:cancelarVenda');
    $app->put('/vendaitem', '\App\Controllers\VendaItemController:updateVendaItem');
    $app->delete('/vendaitem', '\App\Controllers\VendaItemController:deleteVendaItem');
    $app->get('/vendaitem/{id}', '\App\Controllers\VendaItemController:getVendaItens');
    $app->get('/vendaitem/{id}/{item}', '\App\Controllers\VendaItemController:getItemVenda');


    // =========================================Usuario

    $app->get('/usuario', '\App\Controllers\UsuarioController:getUsuario');
    $app->post('/usuario', '\App\Controllers\UsuarioController:insertUsuario');
    $app->put('/usuario', '\App\Controllers\UsuarioController:updateUsuario');
    $app->delete('/usuario', '\App\Controllers\UsuarioController:deleteUsuario');
});

$app->run();
