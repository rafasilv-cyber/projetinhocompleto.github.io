<?php

declare(strict_types=1);

/**
 * --------------------------------------------------------------------------
 * FRONT CONTROLLER - ESTRUTURA DO PROJETO
 * --------------------------------------------------------------------------
 */

// 1. Configuração de exibição de erros (Ambiente de desenvolvimento)
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// 2. Inicialização da Sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Definição de Caminhos Globais com base na sua pasta
define('ROOT_PATH', dirname(__DIR__));               // Raiz do projeto
define('APP_PATH', ROOT_PATH . '/app');             // Pasta app
define('DB_PATH', APP_PATH . '/DB');                 // Pasta app/DB
define('MVC_PATH', APP_PATH . '/mvc');               // Pasta app/mvc
define('CONTROLLER_PATH', MVC_PATH . '/Controller'); // Pasta app/mvc/Controller
define('MODEL_PATH', MVC_PATH . '/Model');           // Pasta app/mvc/Model
define('VIEW_PATH', MVC_PATH . '/View');             // Pasta app/mvc/View

// 4. Autoload de Classes (Carrega Database, Controllers e Models automaticamente)
spl_autoload_register(function (string $className) {
    // Trata a barra de namespaces se você usar (ex: App\Controller\HomeController -> App/Controller/HomeController)
    $classFile = str_replace('\\', '/', $className) . '.php';

    // Lista de locais onde o PHP vai procurar as classes
    $directories = [
        DB_PATH . '/' . $classFile,
        CONTROLLER_PATH . '/' . $classFile,
        MODEL_PATH . '/' . $classFile,
        // Procura direta pelo nome simples da classe (ex: Database.php)
        DB_PATH . '/' . $className . '.php',
        CONTROLLER_PATH . '/' . $className . '.php',
        MODEL_PATH . '/' . $className . '.php',
    ];

    foreach ($directories as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// 5. Roteador Simples e Funcional (Processamento de URL)
$url = $_GET['url'] ?? 'home';
$url = explode('?', $url)[0];
$urlParams = explode('/', trim($url, '/'));

// Define Controller, Método e Parâmetros
$controllerName = ucfirst($urlParams[0] ?? 'Home') . 'Controller';
$methodName = $urlParams[1] ?? 'index';
$params = array_slice($urlParams, 2);

// Execução do Controller
try {
    if (!class_exists($controllerName)) {
        throw new Exception("Controller '{$controllerName}' não encontrado.");
    }

    $controller = new $controllerName();

    if (!method_exists($controller, $methodName)) {
        throw new Exception("O método '{$methodName}' não existe no controller '{$controllerName}'.");
    }

    // Chama o método do controller passando os parâmetros restantes da URL
    call_user_func_array([$controller, $methodName], $params);

} catch (Throwable $e) {
    http_response_code(404);
    echo "<h1>Erro no Sistema</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}