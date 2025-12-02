<?php
namespace App\Services;

class AuthService {
    protected \mysqli $conexion;
    public function __construct(\mysqli $conexion) { $this->conexion = $conexion; }

    public function attempt(string $user, string $password): array {
        $user = trim($user);
        if($user === '' || $password === '') { return ['ok'=>false,'msg'=>'Credenciales vacías']; }
        // Prepared statement
        $stmt = $this->conexion->prepare("SELECT user, pass, feedlot, tipo FROM login WHERE user = ? LIMIT 1");
        if(!$stmt){ return ['ok'=>false,'msg'=>'Error interno']; }
        $stmt->bind_param('s',$user);
        $stmt->execute();
        $res = $stmt->get_result();
        if(!$res || $res->num_rows===0){ return ['ok'=>false,'msg'=>'Usuario inexistente']; }
        $row = $res->fetch_assoc();
        $stored = $row['pass'];
        $valid = false; $rehash = false;
        // Verificar password_hash primero
        $info = password_get_info($stored);
        if(($info['algo'] ?? 0) > 0) {
            $valid = password_verify($password, $stored);
            // Rehash si cost cambió
            if($valid && password_needs_rehash($stored, PASSWORD_DEFAULT)) { $rehash = true; }
        } else {
            // Legacy crypt
            $legacyHash = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
            if(hash_equals($stored,$legacyHash)) { $valid = true; $rehash = true; }
        }
        if(!$valid){ return ['ok'=>false,'msg'=>'Credenciales inválidas']; }
        if($rehash) {
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt2 = $this->conexion->prepare("UPDATE login SET pass=? WHERE user=? LIMIT 1");
            if($stmt2){ $stmt2->bind_param('ss',$newHash,$user); $stmt2->execute(); }
        }
        return ['ok'=>true,'user'=>$row['user'],'feedlot'=>$row['feedlot'],'tipo'=>$row['tipo']];
    }
}
