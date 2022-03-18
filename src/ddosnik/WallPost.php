<?php
namespace ddosnik;

class WallPost {
  public function __construct() {
    echo PHP_EOL.'[AutoComments] Скрипт запущен.';
     $tokens = ['token1', 'token2'];
     $groups = ['-110590021', '-131565695', '-108607290', '-147257236', '-125958582', '-96615701', '-143770865', '-92210377', '-171233799', '-155606969', '-71056933', '-153740237', '-196382872', '-190232436', '-42111958', '-74300654', '-208720662', '-186071388', '-204205656', '-57846937', '-180223076', '-198250204', '-118613947', '-179210668', '-150560775', '-200770687'];
     echo PHP_EOL.'[AutoComments] Внесено групп: '.count($groups);
     echo PHP_EOL.'[AutoComments] Подключено токенов: '.count($tokens);
     while(true) {
     foreach($tokens as $token) {
       foreach($groups as $group) {
         $input = array("🌴😲 Тут реально крутые плагины — vk.com/classicplugins", "🔥⚡ Лол, подписался и мне дали приву — vk.com/classicplugins", "☺💢 Тут реально раздают аккаунты с привами — vk.com/classicplugins", "🌵🌚 Подписался и мне дали аккаунт с привой — vk.com/classicplugins", "🍋🌝 Тут раздают акки с привой — vk.com/classicplugins"); //rand message
         $rand_keys = array_rand($input, 1);
         $message = $input[$rand_keys];
         $lpost_id = $this->getLastPost($group, $token, $message);
         if(!isset($lpost_id)) {
           echo PHP_EOL.'['.$this->getCurrentUserName($token).'] Группа: '.$this->getCurrentGroupName($token, $group).', Произошла ошибка, токен: '.$token;
           continue;
         }
     $res = $this->request('https://api.vk.com/method/wall.createComment?access_token='.$token.'&attachments=photo577945732_457250957&message='.urlencode($message).'&owner_id='.$group.'&post_id='.$lpost_id.'&v=5.131');
     if(!isset($res['response'])) {
       echo PHP_EOL.'['.$this->getCurrentUserName($token).'] Группа: '.$this->getCurrentGroupName($token, $group).', Произошла ошибка: '.$res['error']['error_msg'];
       continue;
     }
     echo PHP_EOL.'['.$this->getCurrentUserName($token).'] Группа: '.$this->getCurrentGroupName($token, $group).', Оставлен комментарий, id комментария - '.$res['response']['comment_id'];
     sleep(15);
    }
   }
 }
}
   public function getCurrentGroupName(string $token, int $group_id) {
     $res = $this->request("https://api.vk.com/method/groups.getById?v=5.173&access_token=".$token."&group_id=".str_replace('-', '', $group_id));
     return $res['response']['groups']['0']['name'];
   }
   public function getCurrentUserName(string $token) {
     $res = $this->request("https://api.vk.com/method/users.get?v=5.173&access_token=".$token);
     return "{$res['response'][0]['first_name']} {$res['response'][0]['last_name']}";
   }
   public function getLastPost($group_id, $token, $message) {
    $wallInfo = json_decode(file_get_contents("https://api.vk.com/method/wall.get?owner_id=$group_id&access_token=$token&count=2&v=5.131"));
    if(!isset($wallInfo->response)) {
      return;
    }
    foreach ($wallInfo->response->items as $item) {
        if(empty($item->is_pinned)) {
            $id = $item->id;
        }
    }
    return $id;
  }
  public function uploadFile($url, $path)
      {
          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_HEADER, false);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_POST, true);

          if (class_exists('\CURLFile')) {
              curl_setopt($ch, CURLOPT_POSTFIELDS, ['file1' => new \CURLFile($path)]);
          } else {
              curl_setopt($ch, CURLOPT_POSTFIELDS, ['file1' => "@$path"]);
          }

          $data = curl_exec($ch);
          curl_close($ch);
          return json_decode($data, true);
      }
  public function request(string $url) {
  			$cURL = curl_init();
  			curl_setopt($cURL, CURLOPT_URL, $url);
  			curl_setopt($cURL, CURLOPT_HTTPGET, true);
  			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
  			curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Accept: application/json'
  ));
  $result = curl_exec($cURL);
  curl_close($cURL);
  return json_decode($result, true);
  	}
}
