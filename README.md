## ConvergeceWorks - correiosrss

Aplicação responsável por consumir um arquivo XML proveniente de https://www.correio24horas.com.br/rss/ e gerar um relatório em formato JSON 
contendo uma lista de notícias.

Utilizando de um formato de aplicação rest API, está gera relatórios a partir dos dados consumidos pelo serviço acima e os filtra em diferentes formatos.

## Requisitos

* PHP >= 7.3

## Instalação

Para buscar dependências do projeto
```
  composer update
```

Para gerar um servidor local
```
  php artisan serve
```

## Utilização

Está rota é responsável pela realização relatórios.

```
  GET api/news
```

```json
  {
    "success": true,
    "error": null,
    "content": {
        "quantidade": 20,
        "noticias": [
            "Capes disponibiliza 3.561 bolsas a 213 instituições de ensino superior",
            "Jorge Vercillo comemora 30 anos de carreira com show Raça Menina",
            "Vereador Gabriel Monteiro é alvo de operação no Rio de Janeiro",
            "O amor existe",
            " Cantoras baianas estão entre as 35 escolhidas para o livro Cantadas",
            "Balé Folclórico retorna com oficinas, nova montagem e a certeza da força do coletivo",
            "Estreia: “Histórias da vida” traz relatos de baianos que usaram a arte como ferramenta de superação",
            "Programa capacita jovens de baixa renda para mercado de trabalho; veja como participar",
            "Terapia: um canal sobre histórias reais de pessoas reais que desembarcou na Bahia",
            "Oito empregadores baianos estão na nova lista suja do trabalho escravo; saiba quais",
            "Homem arremessou mulher de moto antes de matá-la a pedradas, dizem testemunhas",
            "Alunas do Colégio Modelo de Camaçari denunciam professores por assédio ",
            " Guia: tudo o que você precisa saber sobre o uso das máscaras em Salvador",
            "Vinho e Páscoa: 9 dicas para uma harmonização perfeita",
            "Horóscopo de 7/4: veja previsões para esta quinta",
            "Cuidado com a geladeira que você herdou",
            "Pesquisa mostra que Nordeste definirá vencedor do duelo Lula x Bolsonaro",
            "Reconhecimento de paternidade cresce mais de 10 vezes na Bahia em três anos",
            "'É bíblico' diz homem enquanto estuprava a filha",
            "Mega-Sena acumula e próximo concurso deve pagar R$ 45 milhões"
        ]
    }
}
```

Para realizar relatórios filtrados por uma categoria específica

```
  GET api/news/category/{categoryName}
```

```json
  {
    "success": true,
    "error": null,
    "content": {
        "quantidade": 1,
        "noticias": [
            "Vereador Gabriel Monteiro é alvo de operação no Rio de Janeiro"
        ]
    },
    "category": "brasil"
}
```

Para realizar relatório contendo todas as categorias

```
  GET api/newscategory
```

```json
  {
    "success": true,
    "error": null,
    "content": {
        "quantidade": 14,
        "noticias": [
            "entretenimento",
            "educação",
            "brasil",
            "nelson cadena",
            "marrom",
            "de volta",
            "estúdio correio",
            "bahia",
            "salvador",
            "paula theotonio",
            "oscar quiroga",
            "artigo",
            "satélite",
            "em alta"
        ]
    }
}
```

