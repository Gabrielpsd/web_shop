 
 # Agenda APP
 Uma ferramenta de agendamento de tarefas
 
 ## Configuração do ambiente
 Programa construido orientado a micro-serviços, para isso algumas configurações precisam ser feitas no ambiente para uso da ferramenta. 
 
 ### Programas necessários
 1º - O ambiente precisa ter o PHP isntalado na máquina e devidamente parametrizada nas variáveis de ambiente para que possa ser possível utilizado na linah de comando do sistema operacional. Recmonda-se a instalação do XAMPP (link https://www.apachefriends.org/pt_br/index.html).
 2º - O composer precisa ser instalado na maquina. O composer é o gerenciador de pacotes do PHP porém ele não vem por padrão na instalação do PHP. Tutorial de download (https://getcomposer.org/download/).
 3° - Node precisa estar instalado na máquina, juntamente com o Node é necessário que o NPM seja instalado, o NPM é o gerenciador de pacotes do Node, por padrão o npm já vem instalado com o Node. Link para download (https://nodejs.org/pt/download/package-manager).
 4º - PGadmin , o uso de banco de dados fica livre ao usuário, porém na construção do programa foi utilizado o POstgres SQL sendo esse recomendado para quem for utilizar o programa, o PGadmin é a interface responsável por realizar acesso ao banco de dados do PostgresSQL. Link (https://www.pgadmin.org/download/)
 
 ### parametrização do banco dos dados
 1º - Abra o PGadmin e crie um banco de dados;
 2º - Pegue o arquivo .env.example e crie uma cópia do mesmo e remova o ".example" do nome;
 3º - dentro do arquivo .env na seção de banco de dados coloque o os dados de acesso ao banco de dados de acordo com o banco de dados criado no Pgadmin;
 ```
 
 #semelhante ao a seguir 
	DB_CONNECTION=pgsql
	DB_HOST=localhost
	DB_PORT=5432
	DB_DATABASE="NOME BANCO DE DADOS" 
	DB_USERNAME=postgres
	DB_PASSWORD=123
 ```
  4º - Após isso abra o CMD na pasta "server" e digite o comando:
```
  php artisan migrate
```
 !! Caso o erro " could not find driver (Connection: pgsql, SQL: select * from information_schema.tables where table_catalog = agenda and table_schema = public and table_name = migrations and table_type = 'BASE TABLE')" ocorra va para o arquivo php.ini(localizado onde esta instalado o PHP). No arquivo procure por ";extension=pdo_pgsql" remove os dois pontos(";") que antecede a linha. E execute o comando "php artisan migrate" novamente. 

  
 O programa foi construido como SGBD o postgres SQL, porém é possível utilizar outro banco de dados 
### configuração  lado do servidor
 1º - abra o CMD na pasta raiz do programa e execute o seguinte comando:
  ```
composer update
   ```
 2º- Após a instalação de todos os componentes execute o seguinte comando:
  ```
php artisan key:generate
   ```
3º- Após a geração da chave execute o seguinte comando:
  ```
php artisan serve
   ```
4º- Importante destacar que no arquivo .env existe uma configuração "APP_URL" que deve corresponder a mesma rota que o servidor estiver funcionando, caso o servidor inicie em "127.0.0.1" tente acessar o sistema por "localhost" no navegador.

### Configurando lado do cliente
Na pasta "client" abra o cmd, e pós isso execute o comando:
```
npm install
 ```
No diretório "resources\js\Pages\Assets\" há um arquivo denominado "apiconfig.js", esse arquivo é responsável por centralizar todas as rotas utilizadas no programa, caso o programa seja iniciado em uma rota diferente da "http://localhost:8000/" abra esse arquivo e troque a rota para a correta na variavel BASE_URL
```
export const BASE_URL = 'http://localhost:8000'
 ```
Feito todas as intalações execute o seguinte comando:
```
 npm run build
 ```

Confira a rota que aparecerá após a execução do comando. 

## Stacks
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)]()
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)]()
[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)]()
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white)]()
[![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vue.js&logoColor=4FC08D)]()
<center>
<img align="right" src="http://ForTheBadge.com/images/badges/built-with-love.svg" alt="visitor_badge">
</center>
