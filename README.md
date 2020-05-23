# Introdução
Neste repositório você encontrará:

- Conceitos principais do RabbitMQ;
- Processo de instalação e configurações básicas do 
rabbitmq;
- Implementação de alguns tutoriais disponíveis no site do rabbitmq:
    - https://www.rabbitmq.com/tutorials/tutorial-one-php.html
    - https://www.rabbitmq.com/tutorials/tutorial-two-php.html

# Como funciona o RabbitMQ
(Referência: https://www.rabbitmq.com/tutorials/tutorial-one-php.html)

O RabbitMQ age como se fosse uma agência dos correios. Desta forma, ele é responsável por receber e entregar todas as encomendas que foram concedidas à ele.

# Conceitos principais
(Referência: https://www.cloudamqp.com/blog/2015-05-18-part1-rabbitmq-for-beginners-what-is-rabbitmq.html)

- **Producer:** Aplicação que envia a mensagem;

- **Consumer:** Aplicação que recebe a mensagem;

- **Queue:** Buffer que armazena a mensagem;

- **Message:** Informação que é enviada pelo **producer** para o **consumer** através do RabbitMQ;

- **Connection:** Uma conexão TCP entre a sua aplicação (producer or consumer) e o RabbitMQ;

- **Channel:** Uma conexão virtual dentro de uma conexão. Quando publicamos ou consumimos mensagens de uma **queue**, fazemos isso através de um **channel**.

- **Exchange:** Recebe mensagem de um producer e insere as mensagens nas queues dependendo de regras definidas pelo tipo do exchange. Para receber mensagens, uma queue precisa estar "linkada" a pelo menos um exchange.

- **Binding:** Um **bind** é um link entre a queue e o exchange.

- **Routing key:** Uma chave que o **exchange** verifica para dedicir como rotear a mensagem para a queue. Pense na **routing key** como um endereço da mensagem.

- **AMQP:** AMPQ ou Advanced Message Queuing Protocol, é o protocolo utilizado pelo RabbitMQ para mensageria.

- **Users:** É possível conectar ao RabbitMQ através de um usuário e senha. Cada usuário pode ter permissões como: leitura, escrita e gestão de privilégios dentro da instância. Usuários também podem assinar permissões para vhosts especificas.

 - **Vhost, virtual host**: Provê um meio de segregar aplicações usando a mesma instância do RabbitMQ.

# Pré-Requisitos da Instalação

1. Ter o link do instalador do rabbitmq em mãos. Você pode encontrá-lo através do site: https://www.rabbitmq.com/install-windows.html#installer.  

2. Instalar o erlang (caso não tenha instalado, durante o processo de instalação do rabbitmq você receberá um alerta com uma chamada para o site do earlang.);

# Instalação

- Executar o instalador do Earlang;
- Executar o instalador do RabbitMQ:
- Após os passos acima o rabbitmq será instalado e o serviço será iniciado automaticamente;
- Para validar se o serviço está UP:
    - Vá na barra de pesquisa do windows e digite "services";
    - Abrir os serviços do Windows;
    - Procurar por RabbitMQ e verificar se o serviço está com status de "Em execução";
    - Caso não esteja, basta clicar com o botão direito do mouse e clicar em "Iniciar";
- Ao chegar nesse ponto, você tem o rabbitmq rodando na sua estação de trabalho. Entretanto, o mesmo está rodando somente em background e você só consegue acesso a ele através do CMD.

# Criando usuário e subindo interface web

- Vamos disponibilizar uma interface web para gerenciarmos a nossa instância do RabbitMQ (url de referência: https://www.rabbitmq.com/management.html).
    - Vá na barra de pesquisa do windows e digite "rabbitmq";
    - Abra o "RabbitMQ Command Prompt"
        - Se essa opção não ficar disponível para você: "abra o cmd";
        - Navegue até a pasta de instalação do rabbitmq;
        - Acessa a pasta "sbin" (o RabbitMQ Command Prompt é apenas um atalho para esse caminho);
    - Vamos habilitar o plugin "rabbitmq_management";
        - Execute o comando: rabbitmq-plugins.bat enable rabbitmq_management
        - Acesse a página http://localhost:15672/;
    - Criando um usuário para acessar a interface web:
        - Execute o comando: rabbitmqctl add_user {nome_usuario} {senha}
    - Adicione a tag de administrador ao usuário para dar full access: 
        - Execute o comando: rabbitmqctl set_user_tags {nome_usuario} administrator

**Pronto!** Agora, mãos na massa.

# Rodando os tutoriais do rabbitmq

- Faça clone do repositório
- Acesse a pasta do tutorial
- Abra o CMD e digite "composer install". Se você não tiver o composer, realize a instalação através do link: https://getcomposer.org/.
- Através do terminal digite: php send.php (para simular um producer);
- Através do terminal digite: php receive.php (para simular um consumer);