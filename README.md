<h1>Como utilizar este projeto!</h1>
Ele está dividido em 4 partes:

```
/api
/client
/documentacao
/balancedBracket.php
```
Api contém todos fontes referentes a API, rotas e controladoras da mesma.<br>
Client é um exemplo básico de uso da api, sem necessidade de instalações ou composição de processos.<br>
Documentacao contém os fontes responsáveis pela geração dos arquivos de documentação da API.<br>
balancedBracket é a resolução da primeira questão proposta no teste.

<h3>Siga as etapas abaixo:</h3>
<ol>
    <li>Requisitos do servidor.</li>
	<li>Clonar o repositório.</li>
	<li>Instalar Dependências.</li>
	<li>Configurar Base de Dados.</li>
</ol>
&nbsp;
<h2>1. Requisitos do servidor</h2>
O projeto possui um requisito de sistema. 
É necessário verificar se o servidor atende ao seguinte requisito antes de clonar o projeto:
<ul>
    <li>PHP >= 7.3</li>
    <li>OpenSSL PHP Extension</li>
    <li>PDO PHP Extension</li>
    <li>Mbstring PHP Extension</li>
    
</ul>

&nbsp;
<h2>2. Clonar o repositório</h2>
O repositório deve ser clonado no diretório de publicação do servidor web, dependendo da plataforma pode ser: "htdocs", "/var/www"...

```
https://github.com/darleizillmer/project_bravi.git
```

Após o repositório clonado, vamos para a próxima etapa.
<h2>3. Instalar Dependências</h2>
As dependências do projeto estão ligadas a Documentação (Swagger) e ao Lumen
Abra o Terminal, navegue até o diretório do projeto e instale as dependências do projeto com:

```
cd /api
composer install

cd /documentacao
composer install
```

<h2>4. Configurar base de dados</h2>
Após instalar todos os pacotes necessários é preciso configurar o arquivo .env de exemplo, conforme dados do BD, hosts e portas locais ou remotas.

Com isso podem ser executados os comando de migrations e seeders da api, onde serão geradas as tabelas e campos necessárias para seu funcionamento e dados deafult para um usuário primário ter um token de acesso.

```
php artisan migrate

php artisan db:seed
```

Para executar o projeto localmente também é necessário executar:

```
php -S localhost:3000 -t public
```

A porta pode ser alterada evitando conflitos, lembrando que localhost:3000 será a base dos endpoints, logo, caso outra base seja usada, se deve alterar a variável 
```
$baseApi = "http://localhost:3000/v1/"; 
```
no arquivo client/apiCall.php


<h1>Swagger PHP (Documentacao)</h1>
Gera uma documentação OpenAPI interativa para a API usando anotações doctrine.
<h3>Siga as etapas abaixo:</h3>
<ol>
    <li>Instalar Dependências.</li>
    <li>Rodar o comando para gerar yaml da documentação</li>
</ol>
<h2>1. Instalar Dependências</h2>
As dependências do projeto ligadas Testes unitários (PHPUnit). Abra o Terminal, navegue até o diretório do projeto e instale as dependências do PHPUnit com:

```
cd /documentacao
composer install
```

<h2>2. Rodar o comando para gerar yaml da documentação</h2>
Para gerar o arquivo basta abrir o .php de geração no navegador, o yaml será baixado automaticamente.

```
http://localhost/documentacao/gen_doc.php
```

O yaml está na pasta documentacao do projeto, e podem ser conferidos no Swagger Live: https://editor.swagger.io/


