<?php

class NotificacaoModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Registra uma nova notificação no sistema.
     * $tipo: 'novo_chamado' | 'status_alterado' (livre para novos tipos no futuro)
     */
    public function criar(string $tipo, string $mensagem, ?int $chamadoId = null): bool
    {
        $sql = "INSERT INTO notificacoes (tipo, mensagem, chamado_id) VALUES (:tipo, :mensagem, :chamado_id)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':tipo'       => $tipo,
            ':mensagem'   => $mensagem,
            ':chamado_id' => $chamadoId,
        ]);
    }

    public function listarRecentes(int $limite = 6): array
    {
        $sql = "SELECT * FROM notificacoes ORDER BY created_at DESC LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM notificacoes WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function contarNaoLidas(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM notificacoes WHERE lida = 0");
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($res['total'] ?? 0);
    }

    public function marcarComoLida(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE notificacoes SET lida = 1 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function marcarTodasComoLidas(): bool
    {
        $stmt = $this->db->prepare("UPDATE notificacoes SET lida = 1 WHERE lida = 0");
        return $stmt->execute();
    }
}