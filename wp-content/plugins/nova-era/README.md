# Nova Era — Centro de Controlo

Plugin WordPress que adiciona um painel administrativo moderno sem modificar os ficheiros do núcleo nem depender do tema ativo.

## Funcionalidades incluídas

- Página principal própria no menu administrativo.
- Indicadores de artigos publicados, páginas, rascunhos e utilizadores.
- Lista dos conteúdos editados recentemente.
- Atalhos para criar artigos e páginas, abrir o Editor do Site, gerir temas, extensões e biblioteca multimédia.
- Estado básico da versão do WordPress e do PHP.
- Preferências para mensagem de boas-vindas e cor principal do painel.
- Verificação de permissões, nonce, validação e escape de dados nas operações administrativas.
- Estilos carregados apenas nas páginas do plugin e suporte a movimento reduzido.

## Instalação

1. No painel WordPress, abre **Extensões → Extensões instaladas**.
2. Localiza **Nova Era — Centro de Controlo** e seleciona **Ativar**.
3. Abre o menu **Nova Era** na barra lateral administrativa.

O plugin está localizado em `wp-content/plugins/nova-era/`.

## Compatibilidade

- WordPress 6.5 ou superior.
- PHP 7.4 ou superior.
- Requer uma conta com a capacidade `manage_options` para aceder às páginas de administração.

## Segurança e arquitetura

O plugin usa APIs nativas do WordPress, não altera ficheiros de `wp-admin` ou `wp-includes` e não executa consultas SQL diretas. As preferências são guardadas como opções do WordPress. Esta primeira versão não envia dados para serviços externos.

## Próximas etapas previstas

- Centro de notificações e atividade administrativa.
- Ferramentas de desempenho e diagnóstico.
- Gestão de cópias de segurança e atualizações com confirmações explícitas.
- Biblioteca de componentes e padrões de blocos.
- Assistente de conteúdo com integração a IA através de um servidor seguro, sem expor chaves no navegador.
