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

   public function atualizar($id, $nome, $email, $senha)
{
    // Se o usuário digitou uma nova senha, atualiza a senha também
    if (!empty($senha)) {
        $sql = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':senha', password_hash($senha, PASSWORD_DEFAULT));
    } else {
        // Se a senha ficou em branco, mantém a senha antiga e atualiza só nome e email
        $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
    }

    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':id', $id);

    return $stmt->execute();
}

public function excluir($id)
{
    $sql = "DELETE FROM usuarios WHERE id = :id";
    // Trocamos $this->pdo por $this->db
    $stmt = $this->db->prepare($sql); 
    $stmt->bindValue(':id', $id);
    return $stmt->execute();
}

    public function contarTodos(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM usuarios");
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($res['total'] ?? 0);
    }
}