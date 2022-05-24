## Run app as Docker app
For development, clone repository and run it via `docker-compose up -d`

To get into Docker container (etc for composer install dependencies or seed data):

```bash
docker-compose exec php bash
```
Install dependencies
```bash
composer install
```
initialize database 
```bash
bin/console doctrine:database:drop --force && bin/console doctrine:database:create && bin/console doctrine:migration:migrate --no-interaction
```
and run database seed
```bash
bin/console doctrine:fixtures:load 
```
## Test the App
Open http://localhost:1080/graphiql  
and test some results 
```graphql
{
  municipality(name:"kunice") {
    id
    name
    totalVotes
    partiesVotes{
      name
      abbreviation
      percentageResult
    }
    region{
      id
      code
      name
      code2
    }
    district{
      id
      name
    }
  }
}
```


    


### HTTS protocol via self-signed SSL certificate :
>- Add this record to your `/etc/hosts` file (needed for https certificate):
>```text
>127.0.0.1 volby.local
>```
>- Import `.docker/ssl/nginx-selfsigned.crt` to your Google Chrome trusted certificate authorities ([chrome://settings/certificates]()).
>- Run `docker-compose up -d` to start app
>- App API endpoint is available at address [https://volby.local:1443]() 
>
>
>Note:  
>To regenerate self-signed ssl certificate run script
>```bash
>.docker/ssl/generate.sh volby.local
>```