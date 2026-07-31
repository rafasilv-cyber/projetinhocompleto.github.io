<?php

class UsuarioModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listarTodos(): array
    {
        $stmt = $this->db->query("SELECT id, nome, email, created_at FROM usuarios ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(int $id)
    {
        $stmt = $this->db->prepare("SELECT id, nome, email FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cadastrar(array $dados): bool
    {
        // Senha é salva obrigatoriamente usando HASH seguro (Bcrypt)
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome'  => $dados['nome'],
            ':email' => $dados['email'],
            ':senha' => password_hash($dados['senha'], PASSWORD_BCRYPT)
        ]);
    }

    public function atualizar(array $dados): bool
    {
        if (!empty($dados['senha'])) {
            $sql = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
            $params = [
                ':id'    => $dados['id'],
                ':nome'  => $dados['nome'],
                ':email' => $dados['email'],
                ':senha' => password_hash($dados['senha'], PASSWORD_BCRYPT)
            ];
        } else {
            $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
            $params = [
                ':id'    => $dados['id'],
                ':nome'  => $dados['nome'],
                ':email' => $dados['email']
            ];
        }

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function deletar(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function contarTodos(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM usuarios");
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($res['total'] ?? 0);
    }
}