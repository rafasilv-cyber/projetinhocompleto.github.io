<?php

class HomeModel
{
    private $db;

    public function __construct()
    {
        // Obtém a conexão PDO centralizada
        $this->db = Database::getConnection();
    }

    /**
     * RF04 - Retorna todos os indicadores de totais gerais em UMA ÚNICA consulta otimizada
     * (Usado nos cards do topo do Dashboard)
     */
    public function getTotais(): array
    {
        $sql = "SELECT 
                    COUNT(*) AS total_chamados,
                    SUM(CASE WHEN status = 'aberto' THEN 1 ELSE 0 END) AS chamados_abertos,
                    SUM(CASE WHEN status = 'em_andamento' THEN 1 ELSE 0 END) AS chamados_em_andamento,
                    SUM(CASE WHEN status = 'resolvido' THEN 1 ELSE 0 END) AS chamados_resolvidos,
                    SUM(CASE WHEN status = 'cancelado' THEN 1 ELSE 0 END) AS chamados_cancelados
                FROM chamados";

        $stmt = $this->db->query($sql);
        $chamadosStats = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

        // Totais de usuários e categorias cadastrados
        $totalUsuarios = $this->db->query("SELECT COUNT(*) AS total FROM usuarios")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        $totalCategorias = $this->db->query("SELECT COUNT(*) AS total FROM categorias")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        return array_merge($chamadosStats, [
            'total_usuarios'   => (int)$totalUsuarios,
            'total_categorias' => (int)$totalCategorias
        ]);
    }

    /**
     * RF04 - Quantidade de chamados agrupados por Categoria
     * (Ideal para alimentar gráficos de pizza ou barras na View)
     */
    public function getChamadosPorCategoria(): array
    {
        $sql = "SELECT cat.nome AS categoria, COUNT(c.id) AS total
                FROM categorias cat
                LEFT JOIN chamados c ON cat.id = c.categoria_id
                GROUP BY cat.id, cat.nome
                ORDER BY total DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * RF04 - Quantidade de chamados por prioridade (baixa, media, alta, urgente)
     */
    public function getChamadosPorPrioridade(): array
    {
        $sql = "SELECT prioridade, COUNT(*) AS total 
                FROM chamados 
                GROUP BY prioridade";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * RF04 - Tabela resumida com os últimos chamados abertos no sistema
     */
    public function getUltimosChamados(int $limite = 5): array
    {
        $sql = "SELECT c.id, c.titulo, c.status, c.prioridade, c.created_at,
                       cat.nome AS categoria_nome, u.nome AS usuario_nome
                FROM chamados c
                INNER JOIN categorias cat ON c.categoria_id = cat.id
                INNER JOIN usuarios u ON c.usuario_id = u.id
                ORDER BY c.created_at DESC
                LIMIT :limite";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}