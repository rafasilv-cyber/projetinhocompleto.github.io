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
     * RF02 - Listar todos os chamados
     * Traz os nomes do Usuário e da Categoria usando JOIN
     */
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
     * RF02 - Cadastrar novo chamado
     */
    public function cadastrar(array $dados)
    {
        $sql = "INSERT INTO chamados (titulo, descricao, prioridade, categoria_id, usuario_id) 
                VALUES (:titulo, :descricao, :prioridade, :categoria_id, :usuario_id)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':titulo'       => $dados['titulo'],
            ':descricao'    => $dados['descricao'],
            ':prioridade'   => $dados['prioridade'],
            ':categoria_id' => $dados['categoria_id'],
            ':usuario_id'   => $dados['usuario_id']
        ]);
    }

    /**
     * RF02 - Editar chamado existente
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