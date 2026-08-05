<?php

class CategoriaModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listarTodas(): array
    {
        $stmt = $this->db->query("SELECT * FROM categorias ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cadastrar($nome, $descricao)
{
    $sql = "INSERT INTO categorias (nome, descricao) VALUES (:nome, :descricao)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':descricao', $descricao);
    return $stmt->execute();
}

    public function atualizar(array $dados): bool
    {
        $stmt = $this->db->prepare("UPDATE categorias SET nome = :nome, descricao = :descricao WHERE id = :id");
        return $stmt->execute([
            ':id'        => $dados['id'],
            ':nome'      => $dados['nome'],
            ':descricao' => $dados['descricao']
        ]);
    }

    public function deletar(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM categorias WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}