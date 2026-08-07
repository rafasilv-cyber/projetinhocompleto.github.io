<?php

class ChamadoModel
{
    private $db;

    public function __construct()
    {
        // Obtém a conexão PDO via classe Database
        $this->db = Database::getConnection();
    }

    /**
     * RF02 - Cadastrar novo chamado
     * Retorna o ID do chamado recém-criado (0 em caso de falha), para permitir
     * vincular eventos (ex: notificações) ao registro criado.
     */
    public function salvar($titulo, $descricao, $categoria_id, $usuario_id, $prioridade): int
    {
        $sql = "INSERT INTO chamados (titulo, descricao, categoria_id, usuario_id, prioridade) 
                VALUES (:titulo, :descricao, :categoria_id, :usuario_id, :prioridade)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':categoria_id', $categoria_id);
        $stmt->bindValue(':usuario_id', $usuario_id);
        $stmt->bindValue(':prioridade', $prioridade);

        if (!$stmt->execute()) {
            return 0;
        }

        return (int) $this->db->lastInsertId();
    }

    public function listarTodos()
    {
        $sql = "SELECT c.*, cat.nome AS categoria_nome, u.nome AS usuario_nome 
                FROM chamados c
                INNER JOIN categorias cat ON c.categoria_id = cat.id
                INNER JOIN usuarios u ON c.usuario_id = u.id
                ORDER BY c.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lista chamados filtrando por status — usado pelos cards clicáveis do dashboard.
     */
    public function listarPorStatus(string $status): array
    {
        $sql = "SELECT c.*, cat.nome AS categoria_nome, u.nome AS usuario_nome 
                FROM chamados c
                INNER JOIN categorias cat ON c.categoria_id = cat.id
                INNER JOIN usuarios u ON c.usuario_id = u.id
                WHERE c.status = :status
                ORDER BY c.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':status' => $status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * RF05 - Pesquisar chamados por palavra-chave no título ou descrição
     */
    public function pesquisar(string $termo)
    {
        $sql = "SELECT c.*, cat.nome AS categoria_nome, u.nome AS usuario_nome 
                FROM chamados c
                INNER JOIN categorias cat ON c.categoria_id = cat.id
                INNER JOIN usuarios u ON c.usuario_id = u.id
                WHERE c.titulo LIKE :termo OR c.descricao LIKE :termo
                ORDER BY c.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':termo' => '%' . $termo . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar um único chamado por ID para tela de detalhe/edição
     */
    public function buscarPorId(int $id)
    {
        $sql = "SELECT c.*, cat.nome AS categoria_nome, u.nome AS usuario_nome 
                FROM chamados c
                INNER JOIN categorias cat ON c.categoria_id = cat.id
                INNER JOIN usuarios u ON c.usuario_id = u.id
                WHERE c.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * RF02 - Editar chamado existente (edição completa via formulário)
     */
    public function atualizar(array $dados)
    {
        $sql = "UPDATE chamados 
                SET titulo = :titulo, 
                    descricao = :descricao, 
                    status = :status, 
                    prioridade = :prioridade, 
                    categoria_id = :categoria_id 
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'           => $dados['id'],
            ':titulo'       => $dados['titulo'],
            ':descricao'    => $dados['descricao'],
            ':status'       => $dados['status'],
            ':prioridade'   => $dados['prioridade'],
            ':categoria_id' => $dados['categoria_id']
        ]);
    }

    /**
     * Atualização rápida — só o status, usada pela ação "Marcar como resolvido"
     * na listagem e no dashboard, sem precisar abrir o formulário completo.
     */
    public function atualizarStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("UPDATE chamados SET status = :status WHERE id = :id");
        return $stmt->execute([':status' => $status, ':id' => $id]);
    }

    /**
     * RF02 - Excluir chamado pelo ID
     */
    public function deletar(int $id)
    {
        $sql = "DELETE FROM chamados WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * RF04 - Dashboard: Contar total de chamados
     */
    public function contarTodos(): int
    {
        $sql = "SELECT COUNT(*) as total FROM chamados";
        $stmt = $this->db->query($sql);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($resultado['total'] ?? 0);
    }

    /**
     * RF04 - Dashboard: Contar chamados por status ('aberto', 'resolvido', etc)
     */
    public function contarPorStatus(string $status): int
    {
        $sql = "SELECT COUNT(*) as total FROM chamados WHERE status = :status";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':status' => $status]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($resultado['total'] ?? 0);
    }
}