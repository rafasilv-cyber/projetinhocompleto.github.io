<?php

class ConfiguracaoModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Retorna todas as configurações já como array associativo [chave => valor],
     * pronto pra usar direto na view, sem precisar buscar chave por chave.
     */
    public function obterTodas(): array
    {
        $stmt = $this->db->query("SELECT chave, valor FROM configuracoes");
        $linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $config = [];
        foreach ($linhas as $linha) {
            $config[$linha['chave']] = $linha['valor'];
        }
        return $config;
    }

    public function obter(string $chave, string $padrao = ''): string
    {
        $stmt = $this->db->prepare("SELECT valor FROM configuracoes WHERE chave = :chave");
        $stmt->execute([':chave' => $chave]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['valor'] ?? $padrao;
    }

    /**
     * Salva (cria ou atualiza) uma configuração.
     */
    public function salvar(string $chave, string $valor): bool
    {
        $sql = "INSERT INTO configuracoes (chave, valor) VALUES (:chave, :valor)
                ON DUPLICATE KEY UPDATE valor = :valor2";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':chave'  => $chave,
            ':valor'  => $valor,
            ':valor2' => $valor,
        ]);
    }
}