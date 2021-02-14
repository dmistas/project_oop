<?php


class User
{
    private $db, $data, $session_name, $isLoggedIn = false, $cookieName;

    public function __construct(int $id = null)
    {
        $this->db = Database::getInstance();
        $this->session_name = Config::get('session.user_session');
        $this->cookieName = Config::get('cookie.cookie_name');

        if (!$id) {
            if (Session::exists($this->session_name)) {
                $id = Session::get($this->session_name);
                if ($this->find($id)) {
                    $this->isLoggedIn = true;
                }
            }
        } else {
            $this->find($id);
        }
    }

    /**
     * Добавляет пользователя в базу данных 'users'
     * $fields = ['username'=>'name', 'password'=>'pass_hash']
     *
     * @param array $fields
     *
     * @return boolean
     */
    public function createUser($fields = [])
    {
        return $this->db->insert('users', $fields);
    }

    public function login($email = null, $password = null, $remember = false)
    {

        if (!$email && !$password && $this->exists()) {
            Session::put($this->session_name, $this->getData()->id);
            return true;
        } else {
            if ($email) {
                $user = $this->find($email);
                if ($user) {
                    if (password_verify($password, $this->getData()->password)) {
                        Session::put($this->session_name, $this->getData()->id);

                        if ($remember) {
                            $hash = hash('sha256', uniqid());
                            $hashCheck = $this->db->get('user_sessions', ['user_id', '=', $this->getData()->id]);

                            if (!$hashCheck->count()) {
                                $this->db->insert('user_sessions', [
                                    'user_id' => $this->getData()->id,
                                    'hash' => $hash,
                                ]);
                            } else {
                                $hash = $hashCheck->first()->hash;
                            }
                            Cookie::put($this->cookieName, $hash, Config::get('cookie.cookie_expiry'));
                        }

                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function find($value = null)
    {
        if (is_numeric($value)) {
            $this->data = $this->db->get('users', ['id', '=', $value])->first();
        } else {
            $this->data = $this->db->get('users', ['email', '=', $value])->first();
        }
        if ($this->data) {
            return true;
        }
        return false;
    }

    /**
     * Обновляет данные в таблице 'users' по переданному ассоциативному массиву и $id пользователя
     * если не передать id обновляет данные залогиненного пользователя
     *
     * @param array $fields
     * @param null $id
     * @return bool
     */
    public function update($fields = [], $id = null)
    {
        if (!$id && $this->isLoggedIn()){
            $id = $this->getData()->id;
        }
        return $this->db->update('users', $id, $fields);
    }

    public function getData()
    {
        return $this->data;
    }

    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }

    public function logout()
    {
        if ($this->isLoggedIn) {
            $this->db->delete('user_sessions', ['user_id', '=', $this->getData()->id]);
            Session::delete($this->session_name);
            Cookie::delete($this->cookieName);

            return true;
        }
        return false;
    }

    /**
     * Проверяет есть ли запрошенные права н-р: hasPermission('admin')
     *
     * @param string $key
     * @return bool
     */
    public function hasPermissions(string $key=null)
    {
        if ($this->isLoggedIn() && $key){
            $group = $this->db->get('groups', ['id', '=', $this->getData()->group_id]);
            if ($group->count()){
                $permissions = $group->first()->permissions;
                $permissions = json_decode($permissions, true);
                if (isset($permissions[$key])){
                    return boolval($permissions[$key]);
                }
            }
        }
        return false;
    }

    public function exists():bool
    {
        return (!empty($this->getData()));
    }

}