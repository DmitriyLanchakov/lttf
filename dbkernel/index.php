<?php

error_reporting(E_ALL);

require_once('connection.php');
require_once('tools.php');



class Lift_CRUD
{

    var $salt="";

    function test()
    {
        echo "test ok<br>";
    }

    function create($token, $data)
    {

        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            global $connection;
            return pg_insert ($connection, get_class($this), $data);
        }


    }

    function read($token, $condition)
    {

        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            global $connection;
            return pg_select($connection, get_class($this), $condition);

        };


    }

    function getLastId($token = null)
    {

        if(!$token || Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            global $connection;
            $result=pg_query($connection, 'select MAX(id) from "'.get_class($this).'"');
            $result=pg_fetch_all($result);
            return $result[0]['max'];
        };

    }

    function readLimitOffset($token, $limit, $offset)
    {

        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {


            global $connection;
            $result=pg_query($connection, 'select * from "'.get_class($this).' limit '.$limit.' offset '.$offset);
            $result=pg_fetch_all($result);


            return $result;
        }


    }

    function readAll()
    {



        if(empty($error))
        {
            global $connection;

            $result=pg_query($connection, 'select * from "'.get_class($this).'" order by id');


            if($result)
            {
                $result=pg_fetch_all($result);


                return array('success'=>$result);
            }
            else
            {
                $error['database']['pg_query']=true;
                return array('error'=>$error);
            }



        }

    }


    function update($token, $data, $condition)
    {
        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            global $connection;
            return pg_update($connection, get_class($this), $data, $condition);
        }
    }

    function delete($token, $condition)
    {

        //if(empty($condition['id'])) $error['condition']['id']=true;
        if(empty($token)) $error['token']=true;
        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        }


        if(empty($error))
        {
            global $connection;
            $result= pg_delete($connection, get_class($this), $condition);


            if($result)
            {
                $result['success']=$result;
                return array('success'=>$result);


            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        }

    }



    function amount($token)
    {

        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            global $connection;
            $result=pg_query($connection, 'select count(*) as amount from "'.get_class($this).'"');
            $result=pg_fetch_row($result)[0];
            return $result;
        }

    }


};




class Lift_Token extends Lift_CRUD
{

    static  function hasRights($token, $class, $function)
    {

        $query='select "Lift_ACL".class,"Lift_ACL".function, "Lift_User".group  from "Lift_Token"
        left join "Lift_User" on ("Lift_Token".user="Lift_User".id)
        left join "Lift_ACL" on ("Lift_ACL".group="Lift_User".group)
        where "Lift_ACL".class=\''.$class.'\'
        and "Lift_ACL".function=\''.$function.'\'
        and "Lift_Token".token=\''.$token.'\'';


        global $connection;
        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);



        if(!empty($result))
        {
            return true;
        };

    }


    function login($condition, $session_id)
    {


        //if(empty($condition)) $error['condition']=true;
        if(empty($condition['email'])) $error['condition']['email']=true;
        if(empty($condition['password'])) $error['condition']['password']=true;
        if(empty($session_id)) $error['session_id']=true;

        if(empty($error))
        {

            $condition['password']=md5($this->salt.$condition['password']);

            global $connection;
            $user=pg_select($connection, get_class($this), $condition);
            //var_dump($user);
            $user=$user[0];




            if(!empty($user))
            {
                $token=md5($this->salt. $session_id);

                $data=array
                (
                    'user' => $user['id'],
                    'token' => $token
                );

                $result=pg_insert($connection, get_class(), $data);

                if(!$result)
                {

                    $error['database']['pg_insert']=true;
                    return $error;
                };

                $user['token']=$token;
                
                if (!empty($user['data'])) {
                    $data = json_decode($user['data'], true);
                } else {
                    $data = [
                        'phone' => '',
                        'skype' => '',
                        'website' => ''
                    ];
                }
                
                $user = array_merge($user, $data);

                return array('success'=>$user);
            }
            else
            {
                $error['no_user']=true;
                return array('error'=>$error);
            };







        }
        else
        {

            return array('error'=>$error);

        };


    }


    function logout($token)
    {

        if(empty($token)) $error['token']=true;
        if(empty($error))
        {
            $condition=array
            (
                'token'=>$token
            );

            global $connection;
            $result=pg_delete($connection, get_class(), $condition);
            $result['success']=$result;
            return $result;
        }
        else
        {
            $result['error']=$error;
            return $result;
        }


    }





}


class Lift_User extends Lift_Token
{
    function getLastId()
    {
        global $connection;
        $result=pg_query($connection, 'select MAX(id) from "Lift_User"');
        $result=pg_fetch_all($result);
        return $result[0]['max'];
    }



    function readAll()
    {



        if(empty($error))
        {
            global $connection;

            $result=pg_query($connection, 'select * from "'.get_class($this).'" where "deleted"=FALSE order by id');


            if($result)
            {
                $result=pg_fetch_all($result);


                return array('success'=>$result);
            }
            else
            {
                $error['database']['pg_query']=true;
                return array('error'=>$error);
            }



        }

    }


    function read($condition)
    {

     //if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            global $connection;
            $user = pg_select($connection, get_class($this), $condition);
            
            if (!empty($user[0]['data']))
            {
                $user[0] = array_merge(json_decode($user[0]['data'], true), $user[0]);
            }
            
            return $user;
        };


    }
    
    function readCertain($ids)
    {
        global $connection;
        
        $query='SELECT * FROM "' . get_class($this) . '" WHERE id IN (' . implode(',', $ids) . ')';
        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);
        
        return $result;
    }

    function delete($token, $condition)
    {


        if(empty($condition['id'])) $error['condition']['id']=true;
        if(empty($token)) $error['token']=true;
        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        };



        if(empty($error))
        {

            global $connection;

            $condition_parent['user']=$condition['id'];

            $result= pg_delete($connection, get_parent_class($this), $condition_parent);//Lift_Token
            //$result2= pg_delete($connection, get_class($this), $condition);//Lift_User

            $data=array
            (
                'deleted'=>true,
            );

            $result2= pg_update($connection, get_class($this), $data, $condition);//Lift_User



            if($result && $result2)
            {
                return array('success'=>$result2);
            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        };

    }


    function create($token, $data)
    {

        // if(empty($token)) $error['token']=true;
        if(empty($data)) $error['data']=true;
        if(empty($data['first_name'])) $error['data']['first_name']=true;
        if(empty($data['middle_name'])) $error['data']['middle_name']=true;
        if(empty($data['second_name'])) $error['data']['second_name']=true;
        if(empty($data['password']) || !preg_match('/^[a-z0-9`~!@#$%^&*()_\-=+<>:;.,[\]{}|\/\\"\']{6,30}$/i', $data['password'])) $error['data']['password']=true;
        if(empty($data['password_confirmation']) || $data['password_confirmation'] != $data['password']) $error['data']['password_confirmation']=true;
        if(empty($data['group'])) $error['data']['group']=true;
        if(empty($data['type'])) $error['data']['type']=true;
        
        if (empty($data['email'])) {
            $error['data']['email']['empty'] = true;
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $error['data']['email']['format'] = true;
        }


        if (!empty($data['data'])) {
            if (!empty($data['data']['phone'])) {
                if (!preg_match('/^[0-9 ()+-]+$/', $data['data']['phone'])) {
                    $error['data']['phone'] = true;
                }
            }
            
            if (!empty($data['data']['website'])) {
                if (!filter_var($data['data']['website'], FILTER_VALIDATE_URL) && !filter_var('http://' . $data['data']['website'], FILTER_VALIDATE_URL)) {
                    $error['data']['website'] = true;
                }
            }
            
            if (empty($error)) {
                $data['data'] = json_encode($data['data']);
            }
        }


        if($token && !Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        };

        if (!empty($data['email']) && empty($error['data']['email'])) {
            $condition=array
            (
                'email'=>$data['email']
            );

            global $connection;
            $existed_user=pg_select($connection, get_class($this), $condition);


            if(!empty($existed_user)) $error['existed_user']=true;
        }



//        var_dump($error);
//        die();

        if(empty($error))
        {
            $data['password']=md5($this->salt.$data['password']);
            unset($data['password_confirmation']);
            $data['registration_time']=date('Y-m-d H:i:s');
            $data['update_time']=date('Y-m-d H:i:s');

            $result=pg_insert($connection, get_class($this), $data);
//            var_dump($result);die();



            if(empty($result))
            {
                $error['database']['pg_insert']=true;
                return  array('error'=>$error);

            }
            else
            {

                return array('success'=>$result);
            };

        }
        else
        {

            return array('error'=>$error);
        };

    }


    function update_self($token, $data)
    {


        if(empty($token)) $error['token']=true;
        if(empty($data)) $error['data']=true;
        if(empty($data['first_name'])) $error['data']['first_name']=true;
        if(empty($data['middle_name'])) $error['data']['middle_name']=true;
        if(empty($data['second_name'])) $error['data']['second_name']=true;
        if(empty($data['type'])) $error['data']['type']=true;
        
        if (empty($data['email'])) {
            $error['data']['email']['empty'] = true;
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $error['data']['email']['format'] = true;
        }
        
        
        if (!empty($data['password'])) {
            if(!preg_match('/[a-z0-9`~!@#$%^&*()_\-=+<>:;.,[\]{}|\/\\"\']{6,30}/i', $data['password'])) $error['data']['password']=true;
            if(empty($data['password_confirmation']) || $data['password_confirmation'] != $data['password']) $error['data']['password_confirmation']=true;
        }
        
        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        };





        if (!empty($data['data'])) {
            if (!empty($data['data']['phone'])) {
                if (!preg_match('/^[0-9 ()+-]+$/', $data['data']['phone'])) {
                    $error['data']['phone'] = true;
                }
            }
            
            if (!empty($data['data']['website'])) {
                if (!filter_var($data['data']['website'], FILTER_VALIDATE_URL) && !filter_var('http://' . $data['data']['website'], FILTER_VALIDATE_URL)) {
                    $error['data']['website'] = true;
                }
            }
            
            if (empty($error)) {
                $data['data'] = json_encode($data['data']);
            }
        }



        //var_dump($error);die();
        global $connection;


        $condition_select=array
        (
            'token'=>$token
        );

        $user_id=pg_select($connection, get_parent_class($this), $condition_select)[0]['user'];


        if (!empty($data['email']) && empty($error['data']['email'])) {
            $condition_select=array
            (
                'email'=>$data['email']
            );


            $existed_user=pg_select($connection, get_class($this), $condition_select);

            if(!empty($existed_user) && $user_id != $existed_user[0]['id'] )   $error['existed_user']=true;
        }






        if(empty($error))
        {
            unset($data['password_confirmation']);
            if(empty($data['password']))
            {
                unset($data['password']);
            }
            else
            {
                $data['password']=md5($this->salt.$data['password']);
            };

            $data['update_time']=date('Y-m-d H:i:s');



            $condition_update=array
            (
                'id'=>$user_id
            );


            //$result=pg_update($connection, get_class($this), $data, $condition_update);
//
//            middle_name='.$data['middle_name'].',
//            second_name='.$data['second_name'].',
//            email='.$data['email'].',
//            type='.$data['type'].',
//            about='.$data['about'].'





            $query='
            update "Lift_User"
            set
            first_name=\''.$data['first_name'].'\',
            middle_name=\''.$data['middle_name'].'\',
            second_name=\''.$data['second_name'].'\',
            email=\''.$data['email'].'\',
            type=\''.$data['type'].'\',
            ';

            if(!empty($data['password']))
            {
                $query.='password=\''.$data['password'].'\',';
            };

            if(!empty($data['avatar']))
            {
                $query.='avatar=\''.$data['avatar'].'\',';
            };

            if(!empty($data['background']))
            {
                $query.='background=\''.$data['background'].'\',';
            };


            if(!empty($data['data']))
            {

                //$data['data']='{"first_name":"curator","middle_name":"curator","second_name":"curator2","email":"curator@curator.curator","about":null,"type":"2","update_time":"2014-07-01 04:53:42"}';
                $query.='data=\''.$data['data'].'\'::json,';
            };


            $query.='about=\''.$data['about'].'\'
            where id='.$user_id;


//            die($query);

            $result=pg_query($connection, $query);










            if($result)
            {

                return array('success'=>$result);
            }
            else
            {
                $error['database']['pg_update']=true;
                return array('error'=>$error);
            }
        }
        else
        {

            return array('error'=>$error);
        };

    }


    function update($token, $data, $condition)
    {

        if(empty($condition)) $error['condition']=true;
        if(empty($condition['id'])) $error['condition']['id']=true;


        if(empty($token)) $error['token']=true;
        if(empty($data)) $error['data']=true;
        if(empty($data['first_name'])) $error['data']['first_name']=true;
        if(empty($data['middle_name'])) $error['data']['middle_name']=true;
        if(empty($data['second_name'])) $error['data']['second_name']=true;
        if(empty($data['group'])) $error['data']['group']=true;
        if(empty($data['type'])) $error['data']['type']=true;
        
        if (empty($data['email'])) {
            $error['data']['email']['empty'] = true;
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $error['data']['email']['format'] = true;
        }
        
        if (!empty($data['password'])) {
            if(!preg_match('/[a-z0-9`~!@#$%^&*()_\-=+<>:;.,[\]{}|\/\\"\']{6,30}/i', $data['password'])) $error['data']['password']=true;
            if(empty($data['password_confirmation']) || $data['password_confirmation'] != $data['password']) $error['data']['password_confirmation']=true;
        }


        if (!empty($data['data'])) {
            if (!empty($data['data']['phone'])) {
                if (!preg_match('/^[0-9 ()+-]+$/', $data['data']['phone'])) {
                    $error['data']['phone'] = true;
                }
            }
            
            if (!empty($data['data']['website'])) {
                if (!filter_var($data['data']['website'], FILTER_VALIDATE_URL) && !filter_var('http://' . $data['data']['website'], FILTER_VALIDATE_URL)) {
                    $error['data']['website'] = true;
                }
            }
            
            if (empty($error)) {
                $data['data'] = json_encode($data['data']);
            }
        }


        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        }


        if (!empty($data['email']) && empty($error['data']['email'])) {
            $condition_select=array
            (
                'email'=>$data['email']
            );

            global $connection;
            $existed_user=pg_select($connection, get_class($this), $condition_select);

            if(!empty($existed_user) && $condition['id'] != $existed_user[0]['id']) $error['existed_user']=true;
        }








        if(empty($error))
        {
            unset($data['password_confirmation']);
            if(empty($data['password']))
            {
                unset($data['password']);
            }
            else
            {
                $data['password']=md5($this->salt.$data['password']);
            };

            $data['update_time']=date('Y-m-d H:i:s');



            $result =pg_update($connection, get_class($this), $data, $condition);
            if($result)
            {

                return array('success'=>$result);
            }
            else
            {
                $error['database']['pg_update']=true;
                return array('error'=>$error);
            }
        }
        else
        {

            return array('error'=>$error);
        };

    }





};


class Lift_User_group extends Lift_CRUD
{

};

class Lift_ACL extends Lift_CRUD
{

};

class Lift_Heading extends Lift_CRUD
{
    function readAll()
    {

        if(empty($error))
        {
            global $connection;
            $result=pg_query($connection, 'select * from "'.get_class($this).'" order by id');


            if($result)
            {
                $result=pg_fetch_all($result);


                return array('success'=>$result);
            }
            else
            {
                $error['database']['pg_query']=true;
                return array('error'=>$error);
            }

        }

    }

};

class Lift_Subject extends Lift_CRUD
{
    function readAll()
    {

        if(empty($error))
        {
            global $connection;
            $result=pg_query($connection, 'select * from "'.get_class($this).'" order by id');


            if($result)
            {
                $result=pg_fetch_all($result);


                return array('success'=>$result);
            }
            else
            {
                $error['database']['pg_query']=true;
                return array('error'=>$error);
            }

        }

    }

};


class Lift_Blog extends Lift_CRUD
{
    function read($condition)
    {
        global $connection;
        return pg_select($connection, get_class($this), $condition);
    }


    function readAll()
    {




        if(empty($error))
        {
            global $connection;


            $query='select
            "Lift_Blog".id,
            "Lift_Blog".title,
            "Lift_Blog".administrator,
            "Lift_Blog".creation_time,
            "Lift_Blog".editing_time,
            "Lift_Blog".avatar,
            "Lift_Blog".type,
            "Lift_Blog".text,
            "Lift_User".first_name,
            "Lift_User".middle_name,
            "Lift_User".second_name,
            "Lift_User".avatar as user_avatar,
            "Lift_User".id as user_id

            from "Lift_Blog"
            left join "Lift_User" on("Lift_User".id="Lift_Blog".administrator)
            order by "Lift_Blog".id
            ';

            $result=pg_query($connection, $query);
            $result=pg_fetch_all($result);
//            echo "<bl>";
//            var_dump($result);
//            die();



            if($result)
            {



                return array('success'=>$result);
            }
            else
            {
                $error['database']['pg_query']=true;
                return array('error'=>$error);
            }



        }

    }


   function getLastId()
   {
       global $connection;
       $result=pg_query($connection, 'select MAX(id) from "Lift_Blog"');
       $result=pg_fetch_all($result);
       return $result[0]['max'];
   }



    function delete($token, $condition)
    {

        if(empty($condition['id'])) $error['condition']['id']=true;
        if(empty($token)) $error['token']=true;
        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        }


        $condition['type']=2;
        $data['deleted']=true;


        if(empty($error))
        {
            global $connection;

            $result= pg_update($connection, get_class($this), $data, $condition);

            if($result)
            {
                $result['success']=$result;
                return array('success'=>$result);


            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        }

    }

    function amountStatus1()
    {
        $query='select distinct
                "Lift_Blog".title,
                "Lift_Blog".Heading,
                "Lift_Blog".creation_time,
                "Lift_Blog".editing_time,
                "Lift_Blog".id
                from "Lift_Blog"
                left join "Lift_Post" on("Lift_Blog".id="Lift_Post".blog)
                left join "Lift_User" on("Lift_User".id="Lift_Blog".administrator)
                where "Lift_Post".status=1 and "Lift_User".deleted=False';


        global $connection;
        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);
        $result=sizeof($result);

//        echo "<pre>";
//        var_dump($result);
//        die();





        return $result;

    }

    function readLimitOffsetStatus1( $limit, $offset)
    {


        if(empty($error))
        {

            $query='select distinct
            "Lift_Blog".title,
            "Lift_Blog".Heading,
            "Lift_Blog".creation_time,
            "Lift_Blog".editing_time,
            "Lift_Blog".id,
            "Lift_User".avatar as user_avatar,
            "Lift_Blog".avatar,
            "Lift_User".middle_name,
            "Lift_User".first_name,
            "Lift_User".second_name
            from "Lift_Blog"
            left join "Lift_Post" on("Lift_Blog".id="Lift_Post".blog)
            left join "Lift_User" on("Lift_User".id="Lift_Blog".administrator)
            where "Lift_Post".status=1 and "Lift_User".deleted=False  limit '.$limit.' offset '. $offset;


            global $connection;
            $result=pg_query($connection, $query);
            $result=pg_fetch_all($result);


            return array('success'=>$result);

        }
        else
        {

            return  array('error'=>$error);
        }

    }

    function update($token, $data, $condition)
    {


        //if(empty($data['title'])) $error['data']['title']=true;
        //if(empty($data['heading'])) $error['data']['heading']=true;


        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            $error['hasRights']=true;
        };

        //$data['type']=1;
        $data['editing_time']=date('Y-m-d H:i:s');



        if(empty($error))
        {
            global $connection;
            $result= pg_update($connection, get_class($this), $data, $condition);

            if(empty($result))
            {
                $error['database']['pg_insert']=true;
                return  array('error'=>$error);

            }
            else
            {

                return array('success'=>$result);
            };



        }
        else
        {
            return array('error'=>$error);
        }


    }

    function create($token, $data)
    {


        if(empty($data['title'])) $error['data']['title']=true;
        //if(empty($data['heading'])) $error['data']['heading']=true;


        if($token && !Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        };



        $data['creation_time']=date('Y-m-d H:i:s');
        $data['editing_time']=date('Y-m-d H:i:s');






        if(empty($error))
        {
            global $connection;
            $result= pg_insert ($connection, get_class($this), $data);

            if(empty($result))
            {
                $error['database']['pg_insert']=true;
                return  array('error'=>$error);

            }
            else
            {

                return array('success'=>$result);
            };



        }
        else
        {
            return array('error'=>$error);
        }

    }

};


class Lift_Project extends Lift_CRUD
{




    function read_( $condition)
    {
            global $connection;
            return pg_select($connection, get_class($this), $condition);
    }
    
    function readByUser($user_id) {
        global $connection;
        
        $query = '
            SELECT
                DISTINCT "Lift_Project".id,
                "Lift_Project".type,
                "Lift_Project".title,
                "Lift_Project".heading,
                "Lift_Project".administrator,
                "Lift_Project".creation_time,
                "Lift_Project".editing_time,
                "Lift_Project".start_time,
                "Lift_Project".end_time,
                "Lift_Project".description,
                "Lift_Project".relevance,
                "Lift_Project".purpose,
                "Lift_Project".solutions,
                "Lift_Project".background,
                "Lift_Project".avatar
            FROM
                "Lift_Project", "Lift_Project_access"
            WHERE
                "Lift_Project".deleted = false
                AND
                (
                    ("Lift_Project".id = "Lift_Project_access".project AND "Lift_Project_access".user = ' . $user_id . ')
                    OR
                    "Lift_Project".administrator = ' . $user_id . '
                )
            ORDER BY
                "Lift_Project".creation_time DESC
        ';
            
        $result = pg_query($connection, $query);
        $result = pg_fetch_all($result);
        
        return $result;
    }

    function delete($token, $condition)
    {

        if(empty($condition['id'])) $error['condition']['id']=true;
        if(empty($token)) $error['token']=true;
        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        }


        $data['deleted']=true;
        $condition['type']=2;


        if(empty($error))
        {
            global $connection;
            $result= pg_update($connection, get_class($this), $data, $condition);


            if($result)
            {
                $result['success']=$result;
                return array('success'=>$result);


            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        }

    }


    function amountStatus1()
    {
        $query='select distinct
                "Lift_Project".id
                "Lift_Project".title,
                "Lift_Project".Heading,
                "Lift_Project".creation_time,
                "Lift_Project".editing_time,
                from "Lift_Project"
                left join "Lift_Post" on("Lift_Project".id="Lift_Post".blog)
                left join "Lift_User" on("Lift_User".id="Lift_Project".administrator)
                where "Lift_Post".status=1 and "Lift_User".deleted=False';


        global $connection;
        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);
        $result=sizeof($result);

//        echo "<pre>";
//        var_dump($result);
//        die();





        return $result;

    }
    
    function amount_filter($headings)
    {
        if (!empty($headings)) {
            foreach($headings as $key=>$heading)
            {
                $headings_arr[]='"Lift_Project".heading='.$key;
            };

            $where_headings=implode(' or ', $headings_arr);
        }



        $query='SELECT COUNT(*) FROM "Lift_Project"';
        $query.=' where "Lift_Project".deleted=false ';



        if(!empty($where_headings))
        {
            $query.=" and ( ".$where_headings." ) ";
        };

        global $connection;
        $result=pg_query($connection, $query);
        $result=intval(pg_fetch_result($result, 0, 'count'));



        return $result;
    }

    function readLimitOffset_filter($limit, $offset, $headings)
    {
        $query='select
        "Lift_Project".id,
        "Lift_Project".type,
        "Lift_Project".title,
        "Lift_Project".heading,
        "Lift_Project".administrator,
        "Lift_Project".creation_time,
        "Lift_Project".editing_time,
        "Lift_Project".start_time,
        "Lift_Project".end_time,
        "Lift_Project".description,
        "Lift_Project".relevance,
        "Lift_Project".purpose,
        "Lift_Project".solutions,
        "Lift_Project".background,
        "Lift_Project".avatar

        from "Lift_Project" where
        "Lift_Project".deleted=false
        ';
        
        if(!empty($headings))
        {
            foreach($headings as $key=>$heading)
            {
                $headings_arr[]="\"Lift_Project\".heading=".$key;
            };

            $where_headings=implode(' or ', $headings_arr);
            $query.='and ('.$where_headings.') ';
        }
        
        $query.=' order by creation_time desc limit '.$limit.' offset '. $offset;


        global $connection;
        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);


        return array('success'=>$result);
    }

    function update($token, $data, $condition)
    {


        //if(empty($data['title'])) $error['data']['title']=true;
        if(empty($data['heading'])) $error['data']['heading']=true;


        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            $error['hasRights']=true;
        };

        //$data['type']=1;
        $data['editing_time']=date('Y-m-d H:i:s');



        if(empty($error))
        {
            global $connection;
            $result= pg_update($connection, get_class($this), $data, $condition);

            if(empty($result))
            {
                $error['database']['pg_insert']=true;
                return  array('error'=>$error);

            }
            else
            {

                return array('success'=>$result);
            };



        }
        else
        {
            return array('error'=>$error);
        }


    }

    function create($token, $data)
    {


        if(empty($data['title'])) $error['data']['title']=true;
        if(empty($data['heading'])) $error['data']['heading']=true;

        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            $error['hasRights']=true;
        };


        $data['creation_time']=date('Y-m-d H:i:s');
        $data['editing_time']=date('Y-m-d H:i:s');


        if(empty($error))
        {
            global $connection;
            
            $result= pg_insert ($connection, get_class($this), $data);



            if(empty($result))
            {
                $error['database']['pg_insert']=true;
                return  array('error'=>$error);

            }
            else
            {
                return array('success'=>$result);
            };




        }
        else
        {
            return array('error'=>$error);
        }

    }

};






class Lift_Post extends Lift_CRUD
{

    function read_profile( $condition)
    {

        global $connection;
        //return pg_select($connection, get_class($this), $condition);


        $query='SELECT
            "Lift_Post".id,
            "Lift_Post".blog,
            "Lift_Post".title,
            "Lift_Post".text,
            "Lift_Post".annotation,
            "Lift_Post".creation_time,
            "Lift_Post".editing_time,
            "Lift_Post".user,
            "Lift_Post".status,
            "Lift_Post".avatar,
            "Lift_Post".background,

            "Lift_Blog".type as blog_type,
            "Lift_Blog".title as blog_title


            FROM "Lift_Post"
            left join "Lift_Blog"
            on ("Lift_Post".blog="Lift_Blog".id)
            where "Lift_Post".status=1
            and "Lift_Post".user='.$condition['user'].'
            and "Lift_Post".deleted = false
            order by "Lift_Post".creation_time desc';


        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);

//        var_dump($result);



        return $result;




    }

    function read( $condition)
    {

            global $connection;
            return pg_select($connection, get_class($this), $condition);

    }

    function delete($token, $condition)
    {


        if(empty($token)) $error['token']=true;
        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        }


        $data['deleted']=true;

        if(empty($error))
        {
            global $connection;
            $result= pg_update($connection, get_class($this), $data, $condition);

            if($result)
            {
                $result['success']=$result;
                return array('success'=>$result);


            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        }

    }

    function update($token, $data, $condition)
    {





        // if(empty($data['blog'])) $error['data']['blog']=true;
        if(empty($data['title'])) $error['data']['title']=true;
        if(empty($data['text'])) $error['data']['text']=true;
        // if(empty($data['user'])) $error['data']['user']=true;



        if(empty($data['status']))
        {
            $data['status']=0;
        }
        else
        {
            $data['status']=1;
        };





        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        };




        $data['editing_time']=date('Y-m-d H:i:s');



        if(empty($error))
        {




            global $connection;
            $result= pg_update($connection, get_class($this), $data, $condition);




            if(empty($result))
            {
                $error['database']['pg_insert']=true;
                return  array('error'=>$error);

            }
            else
            {

                return array('success'=>$result);
            };

        }
        else
        {
            return array('error'=>$error);
        }













    }





    function readLimitOffset_filter($limit, $offset, $headings, $subjects, $orderby,  $from, $to)
    {
        if (!empty($headings)) {
            foreach($headings as $key=>$heading)
            {
                $headings_arr[]="\"Lift_Post_Heading\".heading=".$key;
            };

            $where_headings=implode(' or ', $headings_arr);
        }

        if (!empty($subjects)) {
            foreach($subjects as $key=>$subject)
            {
                $subjects_arr[]="\"Lift_Post_Subject\".subject=".$key;
            };

            $where_subjects=implode(' or ', $subjects_arr);
        }



        $query='select distinct
        "Lift_Post".id,
        "Lift_Post".blog,
        "Lift_Post".title,
        "Lift_Post".text,
        "Lift_Post".annotation,
        "Lift_Post".creation_time,
        "Lift_Post".editing_time,
        "Lift_Post".user,
        "Lift_Post".status,
        "Lift_Post".avatar,
        "Lift_Post".background,
        "Lift_User".id as user_id,
        "Lift_User".first_name,
        "Lift_User".middle_name,
        "Lift_User".second_name,
        "Lift_User".avatar as user_avatar,

        (
            select count(*) from "Lift_Post_ip"
            where "Lift_Post_ip".post="Lift_Post".id
        ) as views_amount,

        (
            select count(*) from "Lift_Commentary"
            where "Lift_Commentary".post="Lift_Post".id
        ) as commentary_amount




        from "Lift_Post"

        left join "Lift_Blog" on("Lift_Blog".id="Lift_Post".blog)
        left join "Lift_User" on("Lift_User".id="Lift_Post".user)
        left join "Lift_Post_Heading" on("Lift_Post".id="Lift_Post_Heading".post)
        left join "Lift_Post_Subject" on("Lift_Post".id="Lift_Post_Subject".post)




        where "Lift_Post".status=1 and "Lift_Post".deleted=false ';

        if (!empty($where_headings)) {
            $query .= " and ( ".$where_headings." ) ";
        };

        if (!empty($where_subjects)) {
            $query .= " and ( ".$where_subjects." ) ";
        };


        if (!empty($from)) {
            $query .= " and \"Lift_Post\".creation_time>='".$from."' ";
        }

        if (!empty($to)) {
            $query .= " and \"Lift_Post\".creation_time<='".$to."' ";
        }





        switch ($orderby)
        {
            case "read":
                $query.=' order by views_amount desc ';
                break;
            case "discussed":
                $query.=' order by commentary_amount desc';
                break;
            case "new":
                $query.=' order by "Lift_Post".creation_time desc ';
                break;
            case "old":
                $query.=' order by "Lift_Post".creation_time asc ';
                break;

            default:
                $query.=' order by "Lift_Post".id ';
        };
        
        if (!empty($limit)) {
            $query .= ' limit ' . $limit;
        }

        if (!empty($offset)) {
            $query .= ' offset '. $offset;
        }

        global $connection;
        $result = pg_query($connection, $query);
        $result = pg_fetch_all($result);

        return ['success' => $result];
    }

    //function readLimitOffset_filter($limit, $offset, $headings, $subjects, $orderby,  $from, $to)
    function readAll_filter( $headings, $subjects, $orderby,  $from, $to)
    {


        if(empty($error))
        {
            if (!empty($headings)) {
                foreach($headings as $key=>$heading)
                {
                    $headings_arr[]="\"Lift_Post_Heading\".heading=".$key;
                };

                $where_headings=implode(' or ', $headings_arr);
            }

            if (!empty($subjects)) {
                foreach($subjects as $key=>$subject)
                {
                    $subjects_arr[]="\"Lift_Post_Subject\".subject=".$key;
                };

                $where_subjects=implode(' or ', $subjects_arr);
            }



            $query='select distinct
            "Lift_Post".id,
            "Lift_Post".blog,
            "Lift_Post".title,
            "Lift_Post".text,
            "Lift_Post".annotation,
            "Lift_Post".creation_time,
            "Lift_Post".editing_time,
            "Lift_Post".user,
            "Lift_Post".status,
            "Lift_Post".avatar,
            "Lift_Post".background,
            "Lift_User".id as user_id,
            "Lift_User".first_name,
            "Lift_User".middle_name,
            "Lift_User".second_name,
            "Lift_User".avatar as user_avatar,

            (
                select count(*) from "Lift_Post_ip"
                where "Lift_Post_ip".post="Lift_Post".id
            ) as views_amount,

            (
                select count(*) from "Lift_Commentary"
                where "Lift_Commentary".post="Lift_Post".id
            ) as commentary_amount




            from "Lift_Post"

            left join "Lift_Blog" on("Lift_Blog".id="Lift_Post".blog)
            left join "Lift_User" on("Lift_User".id="Lift_Post".user)
            left join "Lift_Post_Heading" on("Lift_Post".id="Lift_Post_Heading".post)
            left join "Lift_Post_Subject" on("Lift_Post".id="Lift_Post_Subject".post)




            where "Lift_Post".status=1  and "Lift_Post".deleted=false ';

            if(!empty($where_headings))
            {
                $query.="
             and ( ".$where_headings." ) ";
            };

            if(!empty($where_subjects))
            {
                $query.="
             and ( ".$where_subjects." ) ";
            };


            if(!empty($from))
            {
                $query.=" and \"Lift_Post\".creation_time>='".$from."' ";
            }

            if(!empty($to))
            {
                $query.=" and \"Lift_Post\".creation_time<='".$to."' ";
            }





            switch ($orderby)
            {
                case "read":
                    $query.=' order by views_amount desc ';
                    break;
                case "discussed":
                    $query.=' order by commentary_amount desc';
                    break;
                case "new":
                    $query.=' order by "Lift_Post".creation_time desc ';
                    break;
                case "old":
                    $query.=' order by "Lift_Post".creation_time asc ';
                    break;

                default:
                    $query.=' order by "Lift_Post".id ';
            };


            $query.=' limit 500 ';


            global $connection;
            $result=pg_query($connection, $query);
            $result=pg_fetch_all($result);


            return array('success'=>$result);

        }
        else
        {

            return  array('error'=>$error);
        }

    }



    function amountOfPosts_filter($headings, $subjects, $from, $to)
    {

        foreach($headings as $key=>$heading)
        {
            $headings_arr[]="\"Lift_Post_Heading\".heading=".$key;
        };

        $where_headings=implode(' or ', $headings_arr);




        foreach($subjects as $key=>$subject)
        {
            $subjects_arr[]="\"Lift_Post_Subject\".subject=".$key;
        };

        $where_subjects=implode(' or ', $subjects_arr);



        $query='select distinct
            "Lift_Post".id,
            "Lift_Post".blog,
            "Lift_Post".title,
            "Lift_Post".text,
            "Lift_Post".annotation,
            "Lift_Post".creation_time,
            "Lift_Post".editing_time,
            "Lift_Post".user,
            "Lift_Post".status,
            "Lift_Post".avatar,
            "Lift_Post".background,
            "Lift_User".id as user_id,
            "Lift_User".first_name,
            "Lift_User".middle_name,
            "Lift_User".second_name,
            "Lift_User".avatar as user_avatar


            from "Lift_Post"

            left join "Lift_Blog" on("Lift_Blog".id="Lift_Post".blog)
            left join "Lift_User" on("Lift_User".id="Lift_Post".user)
            left join "Lift_Post_Heading" on("Lift_Post".id="Lift_Post_Heading".post)
            left join "Lift_Post_Subject" on("Lift_Post".id="Lift_Post_Subject".post)



            where "Lift_Post".status=1 and "Lift_Post".deleted=false ';



        if(!empty($where_headings))
        {
            $query.="
             and ( ".$where_headings." ) ";
        };

        if(!empty($where_subjects))
        {
            $query.="
             and ( ".$where_subjects." ) ";
        };


        if(!empty($from))
        {
            $query.=" and \"Lift_Post\".creation_time>='".$from."' ";
        }

        if(!empty($to))
        {
            $query.=" and \"Lift_Post\".creation_time<='".$to."' ";
        }

        global $connection;
        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);

        $result=sizeof($result);
        return $result;

    }



    function amountOfPosts_filter_blogId($blog_id, $headings, $subjects, $from, $to )
    {

        foreach($headings as $key=>$heading)
        {
            $headings_arr[]="\"Lift_Post_Heading\".heading=".$key;
        };

        $where_headings=implode(' or ', $headings_arr);




        foreach($subjects as $key=>$subject)
        {
            $subjects_arr[]="\"Lift_Post_Subject\".subject=".$key;
        };

        $where_subjects=implode(' or ', $subjects_arr);



        $query='select distinct
            "Lift_Post".id,
            "Lift_Post".blog,
            "Lift_Post".title,
            "Lift_Post".text,
            "Lift_Post".annotation,
            "Lift_Post".creation_time,
            "Lift_Post".editing_time,
            "Lift_Post".user,
            "Lift_Post".status,
            "Lift_Post".avatar,
            "Lift_Post".background,
            "Lift_User".id as user_id,
            "Lift_User".first_name,
            "Lift_User".middle_name,
            "Lift_User".second_name,
            "Lift_User".avatar as user_avatar


            from "Lift_Post"

            left join "Lift_Blog" on("Lift_Blog".id="Lift_Post".blog)
            left join "Lift_User" on("Lift_User".id="Lift_Post".user)
            left join "Lift_Post_Heading" on("Lift_Post".id="Lift_Post_Heading".post)
            left join "Lift_Post_Subject" on("Lift_Post".id="Lift_Post_Subject".post)


            where "Lift_Post".status=1 and
            "Lift_Post".blog='.$blog_id;


        //left join "Lift_Post_Heading" on("Lift_Post_Heading".post="Lift_Post".id)
        //left join "Lift_Post_Subject" on("Lift_Post_Subject".post="Lift_Post".id)

        if(!empty($where_headings))
        {
            $query.="
             and ( ".$where_headings." ) ";
        };

        if(!empty($where_subjects))
        {
            $query.="
             and ( ".$where_subjects." ) ";
        };


        if(!empty($from))
        {
            $query.=" and \"Lift_Post\".creation_time>='".$from."' ";
        }

        if(!empty($to))
        {
            $query.=" and \"Lift_Post\".creation_time<='".$to."' ";
        }

        global $connection;
        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);




        //$result=array_unique($result);
//        echo "<pre>";
//        var_dump($result);
//        die();
        $result=sizeof($result);
        return $result;









//            global $connection;
//
//            $query='select distinct
//            count(*)
//            from "Lift_Post"
//            where "Lift_Post".status=1
//            and "Lift_Post".blog='.$blog_id;
//
//            $result=pg_query($connection, $query);
//
//            $result=pg_fetch_row($result)[0];
//
//            return $result;

    }

    function amountOfPosts($blog_id)
    {

            global $connection;

            $query='select distinct
            count(*)
            from "Lift_Post"
            where
            "Lift_Post".blog='.$blog_id;

            $result=pg_query($connection, $query);
            $result=pg_fetch_row($result)[0];

            return $result;

    }

    function readAllBlog_id($token, $blog_id)
    {

        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            global $connection;
            //select * from "Lift_Post" where "user"='5';


            $query='select distinct
            count(*)
            from "Lift_Post"
            left join "Lift_Blog_access" on ("Lift_Post".blog="Lift_Blog_access".blog)
            where "Lift_Post".blog='.$blog_id;

            $result=pg_query($connection, $query);
            //$result=pg_fetch_row($result);
            $result=pg_fetch_row($result)[0];
            return $result;
        }

    }

    function readLimitOffset_filter_BlogId($blog_id, $limit, $offset, $headings, $subjects, $orderby,  $from, $to)
    {


        if(empty($error))
        {

            foreach($headings as $key=>$heading)
            {
                $headings_arr[]="\"Lift_Post_Heading\".heading=".$key;
            };

            $where_headings=implode(' or ', $headings_arr);




            foreach($subjects as $key=>$subject)
            {
                $subjects_arr[]="\"Lift_Post_Subject\".subject=".$key;
            };

            $where_subjects=implode(' or ', $subjects_arr);



            $query='select distinct
            "Lift_Post".id,
            "Lift_Post".blog,
            "Lift_Post".title,
            "Lift_Post".text,
            "Lift_Post".annotation,
            "Lift_Post".creation_time,
            "Lift_Post".editing_time,
            "Lift_Post".user,
            "Lift_Post".status,
            "Lift_Post".avatar,
            "Lift_Post".background,
            "Lift_User".id as user_id,
            "Lift_User".first_name,
            "Lift_User".middle_name,
            "Lift_User".second_name,
            "Lift_User".avatar as user_avatar,

            (
                select count(*) from "Lift_Post_ip"
                where "Lift_Post_ip".post="Lift_Post".id
            ) as views_amount,

            (
                select count(*) from "Lift_Commentary"
                where "Lift_Commentary".post="Lift_Post".id
            ) as commentary_amount




            from "Lift_Post"

            left join "Lift_Blog" on("Lift_Blog".id="Lift_Post".blog)
            left join "Lift_User" on("Lift_User".id="Lift_Post".user)
            left join "Lift_Post_Heading" on("Lift_Post".id="Lift_Post_Heading".post)
            left join "Lift_Post_Subject" on("Lift_Post".id="Lift_Post_Subject".post)



            where "Lift_Post".status=1 and
             "Lift_Post".blog='.$blog_id;


            if(!empty($where_headings))
            {
                $query.="
             and ( ".$where_headings." ) ";
            };

            if(!empty($where_subjects))
            {
                $query.="
             and ( ".$where_subjects." ) ";
            };


            if(!empty($from))
            {
                $query.=" and \"Lift_Post\".creation_time>='".$from."' ";
            }

            if(!empty($to))
            {
                $query.=" and \"Lift_Post\".creation_time<='".$to."' ";
            }



            switch ($orderby)
            {
                case "read":
                    $query.=' order by views_amount desc ';
                    break;
                case "discussed":
                    $query.=' order by commentary_amount desc';
                    break;
                case "new":
                    $query.=' order by "Lift_Post".creation_time desc ';
                    break;
                case "old":
                    $query.=' order by "Lift_Post".creation_time asc ';
                    break;

                default:
                    $query.=' order by "Lift_Post".id ';
            }








            $query.=' limit '.$limit.' offset '. $offset;


            global $connection;
            $result=pg_query($connection, $query);
            $result=pg_fetch_all($result);


//            var_dump($result);
//            die();
//var_dump($query);
//            die();



            return array('success'=>$result);

        }
        else
        {

            return  array('error'=>$error);
        }

























//            global $connection;
//            $query='select distinct
//            "Lift_Post".id,
//            "Lift_Post".title,
//            "Lift_Post".text,
//            "Lift_User".avatar,
//            "Lift_User".first_name,
//            "Lift_User".middle_name,
//            "Lift_User".second_name
//            from "Lift_Post"
//            left join "Lift_Blog_access" on ("Lift_Post".blog="Lift_Blog_access".blog)
//            left join "Lift_User" on ("Lift_Post".user = "Lift_User".id)
//            where "Lift_Post".status=1 and "Lift_Blog_access".blog='.$blog_id.'limit '. $limit. 'offset '. $offset;
//
//            $result=pg_query($connection, $query);
//            $result=pg_fetch_all($result);
//
//            return $result;




    }

    function readPosts_LimitOffset( $limit, $offset, $blog_id)
    {


            global $connection;

            $query='select
            distinct
            "Lift_Post".id,"Lift_Post".title,"Lift_Post".text, "Lift_Post".creation_time from "Lift_Post"
            left join "Lift_Blog_access" on ("Lift_Post".blog="Lift_Blog_access".blog)
            where "Lift_Blog_access".blog='.$blog_id.'limit '. $limit. 'offset '. $offset;

            $result=pg_query($connection, $query);
            $result=pg_fetch_all($result);


            return $result;


    }

    function create($token, $data)
    {


        if(empty($data['blog'])) $error['data']['blog']=true;
        if(empty($data['title'])) $error['data']['title']=true;
        if(empty($data['text'])) $error['data']['text']=true;
        if(empty($data['user'])) $error['data']['user']=true;

        $data['creation_time']=date('Y-m-d H:i:s');
        $data['editing_time']=date('Y-m-d H:i:s');
        //if(empty($data['status'])) $data['status']=0;




        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            $error['hasRights']=true;
        };



        $data['creation_time']=date('Y-m-d H:i:s');
        $data['editing_time']=date('Y-m-d H:i:s');





        if(empty($error))
        {

            global $connection;
            $result= pg_insert ($connection, get_class($this), $data);


            if(empty($result))
            {

                //var_dump($data);

                $error['database']['pg_insert']=true;
                return  array('error'=>$error);



            }
            else
            {

                return array('success'=>$result);
            };

        }
        else
        {
            return array('error'=>$error);
        }

    }

    function amountUser_id($token, $user_id)
    {

        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            global $connection;
            //select * from "Lift_Post" where "user"='5';
            //$user_id=5;

            $result=pg_query($connection, 'select * from "'.get_class($this).'" where "user"='.$user_id);
            $result=pg_fetch_row($result);
            //$result=pg_fetch_row($result)[0];
            return $result;
        }

    }


};

class Lift_Task extends Lift_CRUD
{

    function read_profile( $condition)
    {

        global $connection;
        //return pg_select($connection, get_class($this), $condition);


        $query='SELECT
            "Lift_Task".id,
            "Lift_Task".title,
            "Lift_Task".text,
            "Lift_Task".creation_time,
            "Lift_Task".editing_time,
            "Lift_Task".user,
            "Lift_Task".status,

            "Lift_Blog".type as blog_type,
            "Lift_Blog".title as blog_title,
            "Lift_Blog".heading as blog_heading

            FROM "Lift_Task"
            left join "Lift_Blog"
            on ("Lift_Task".blog="Lift_Blog".id)
            where "Lift_Task".status=1
            and "Lift_Task".user='.$condition['user']
            .'order by "Lift_Task".creation_time desc';


        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);


        return $result;




    }

    function read( $condition)
    {

        global $connection;
        return pg_select($connection, get_class($this), $condition);

    }

    function delete($token, $condition)
    {


        if(empty($token)) $error['token']=true;
        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        }


        if(empty($error))
        {


            $data['deleted']=true;


            global $connection;
            $result= pg_update($connection, get_class($this), $data, $condition);




            if($result)
            {
                $result['success']=$result;
                return array('success'=>$result);


            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        }

    }

    function update($token, $data, $condition)
    {





        //if(empty($data['blog'])) $error['data']['blog']=true;
        if(empty($data['title'])) $error['data']['title']=true;
        if(empty($data['text'])) $error['data']['text']=true;
        if(empty($data['status'])) $error['data']['status']=true;
        //if(empty($data['user'])) $error['data']['user']=true;




        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        };




        $data['editing_time']=date('Y-m-d H:i:s');



        if(empty($error))
        {





            global $connection;
            $result= pg_update($connection, get_class($this), $data, $condition);





            if(empty($result))
            {
                $error['database']['pg_insert']=true;
                return  array('error'=>$error);

            }
            else
            {

                return array('success'=>$result);
            };

        }
        else
        {
            return array('error'=>$error);
        }













    }

    function amountOfPosts_status1($project_id)
    {

        global $connection;

        $query='select distinct
            count(*)
            from "Lift_Task"
            where "Lift_Task".status=1
            and "Lift_Task".blog='.$blog_id;

        $result=pg_query($connection, $query);
        //$result=pg_fetch_row($result);
        $result=pg_fetch_row($result)[0];

        //var_dump($result);
        //die();
        return $result;

    }

    function amountOfTasks($project_id)
    {

        global $connection;

        $query='select distinct
            count(*)
            from "Lift_Task"
            where
            "Lift_Task".project='.$project_id;

        $result=pg_query($connection, $query);
        $result=pg_fetch_row($result)[0];

        return $result;

    }

    function readAllBlog_id($token, $project_id)
    {

        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            global $connection;
            //select * from "Lift_Task" where "user"='5';


            $query='select distinct
            count(*)
            from "Lift_Task"
            left join "Lift_Blog_access" on ("Lift_Task".blog="Lift_Blog_access".blog)
            where "Lift_Task".deleted=false and "Lift_Task".blog='.$blog_id;

            $result=pg_query($connection, $query);
            //$result=pg_fetch_row($result);
            $result=pg_fetch_row($result)[0];
            return $result;
        }

    }

    function readPosts_Status1LimitOffset( $limit, $offset, $project_id)
    {


        global $connection;
        $query='select distinct
            "Lift_Task".id,
            "Lift_Task".title,
            "Lift_Task".text
            from "Lift_Task"
            left join "Lift_Blog_access" on ("Lift_Task".blog="Lift_Blog_access".blog)
            where "Lift_Task".status=1 and "Lift_Blog_access".blog='.$blog_id.'limit '. $limit. 'offset '. $offset;

        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);


        return $result;




    }

    function readTasks_LimitOffset( $limit, $offset, $project_id)
    {


        global $connection;

        $query='select
            "Lift_Task".id,
            "Lift_Task".project,
            "Lift_Task".title,
            "Lift_Task".text,
            "Lift_Task".creation_time,
            "Lift_Task".editing_time,
            "Lift_Task".user,
            "Lift_Task".status,
            "Lift_Task".start_time,
            "Lift_Task".end_time,
            (
                select count(*) from "Lift_Tskcommentary"
                where "Lift_Tskcommentary".task="Lift_Task".id and "Lift_Tskcommentary".deleted = false
            ) as commentary_amount
            
            from "Lift_Task"
            where "Lift_Task".deleted=false and "Lift_Task".project='.$project_id.' order by "Lift_Task".creation_time desc
            limit '. $limit. ' offset '. $offset;

        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);

        return $result;


    }

    function create($token, $data)
    {


        if(empty($data['project'])) $error['data']['project']=true;
        if(empty($data['title'])) $error['data']['title']=true;
        if(empty($data['text'])) $error['data']['text']=true;
        if(empty($data['user'])) $error['data']['user']=true;
        if(empty($data['status'])) $error['data']['status']=true;

        $data['creation_time']=date('Y-m-d H:i:s');
        $data['editing_time']=date('Y-m-d H:i:s');
        //if(empty($data['status'])) $data['status']=0;




        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            $error['hasRights']=true;
        };



        $data['creation_time']=date('Y-m-d H:i:s');
        $data['editing_time']=date('Y-m-d H:i:s');





        if(empty($error))
        {

            global $connection;
            $result= pg_insert ($connection, get_class($this), $data);


            if(empty($result))
            {

                //var_dump($data);

                $error['database']['pg_insert']=true;
                return  array('error'=>$error);



            }
            else
            {

                return array('success'=>$result);
            };

        }
        else
        {
            return array('error'=>$error);
        }

    }

    function amountUser_id($token, $user_id)
    {

        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            global $connection;
            //select * from "Lift_Task" where "user"='5';
            //$user_id=5;

            $result=pg_query($connection, 'select * from "'.get_class($this).'" where "user"='.$user_id);
            $result=pg_fetch_row($result);
            //$result=pg_fetch_row($result)[0];
            return $result;
        }

    }

};





class Lift_Prpost extends Lift_CRUD
{

    function read_profile( $condition)
    {

        global $connection;
        //return pg_select($connection, get_class($this), $condition);


        $query='SELECT
            "Lift_Prpost".id,
            "Lift_Prpost".blog,
            "Lift_Prpost".title,
            "Lift_Prpost".text,
            "Lift_Prpost".creation_time,
            "Lift_Prpost".editing_time,
            "Lift_Prpost".user,
            "Lift_Prpost".status,

            "Lift_Blog".type as blog_type,
            "Lift_Blog".title as blog_title,
            "Lift_Blog".heading as blog_heading

            FROM "Lift_Prpost"
            left join "Lift_Blog"
            on ("Lift_Prpost".blog="Lift_Blog".id)
            where "Lift_Prpost".status=1
            and "Lift_Prpost".user='.$condition['user']
            .'order by "Lift_Prpost".creation_time desc';


        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);


        return $result;

    }

    function read( $condition)
    {

        global $connection;
        return pg_select($connection, get_class($this), $condition);

    }


    function read_first( $project_id)
    {

        $query='SELECT *

            FROM "Lift_Prpost"
            where "Lift_Prpost".project='.$project_id.'
            order by "Lift_Prpost".id asc limit 1
            ';

        global $connection;
        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);


        return $result;

    }

    function delete($token, $condition)
    {


        if(empty($token)) $error['token']=true;
        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        }


        if(empty($error))
        {
            global $connection;
            $result= pg_delete($connection, get_class($this), $condition);




            if($result)
            {
                $result['success']=$result;
                return array('success'=>$result);


            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        }

    }

    function update($token, $data, $condition)
    {
        if(empty($data['title'])) $error['data']['title']=true;
        if(empty($data['text'])) $error['data']['text']=true;



        if(empty($data['status']))
        {
            $data['status']=0;
        }
        else
        {
            $data['status']=1;
        };





        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        };




        $data['editing_time']=date('Y-m-d H:i:s');



        if(empty($error))
        {
            global $connection;
            $result= pg_update($connection, get_class($this), $data, $condition);

            if(empty($result))
            {
                $error['database']['pg_insert']=true;
                return  array('error'=>$error);

            }
            else
            {

                return array('success'=>$result);
            };

        }
        else
        {
            return array('error'=>$error);
        }













    }

    function amountOfPrposts_status1($blog_id)
    {

        global $connection;

        $query='select distinct
            count(*)
            from "Lift_Prpost"
            where "Lift_Prpost".status=1
            and "Lift_Prpost".blog='.$blog_id;

        $result=pg_query($connection, $query);
        //$result=pg_fetch_row($result);
        $result=pg_fetch_row($result)[0];

        //var_dump($result);
        //die();
        return $result;

    }

    function amountOfPrposts($project_id)
    {

        global $connection;

        $query='select distinct
            count(*)
            from "Lift_Prpost"
            where
            "Lift_Prpost".project='.$project_id;

        $result=pg_query($connection, $query);
        $result=pg_fetch_row($result)[0];

        return $result;

    }

    function readAllBlog_id($token, $project_id)
    {

        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            global $connection;
            //select * from "Lift_Prpost" where "user"='5';


            $query='select distinct
            count(*)
            from "Lift_Prpost"
            left join "Lift_Blog_access" on ("Lift_Prpost".blog="Lift_Blog_access".blog)
            where "Lift_Prpost".project='.$project_id;

            $result=pg_query($connection, $query);
            //$result=pg_fetch_row($result);
            $result=pg_fetch_row($result)[0];
            return $result;
        }

    }

    function readPrposts_Status1LimitOffset( $limit, $offset, $blog_id)
    {


        global $connection;
        $query='select distinct
            "Lift_Prpost".id,
            "Lift_Prpost".title,
            "Lift_Prpost".text
            from "Lift_Prpost"
            left join "Lift_Blog_access" on ("Lift_Prpost".blog="Lift_Blog_access".blog)
            where "Lift_Prpost".status=1 and "Lift_Blog_access".blog='.$blog_id.'limit '. $limit. 'offset '. $offset;

        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);


        return $result;




    }

    //function readLimitOffset_filter($limit, $offset, $headings, $subjects, $orderby,  $from, $to)
    function readAll_filter( $headings, $subjects, $orderby,  $from, $to, $limit=500, $offset=0)
    {
        $query='select distinct
        "Lift_Prpost".id,
        "Lift_Prpost".project,
        "Lift_Prpost".title,
        "Lift_Prpost".text,
        "Lift_Prpost".creation_time,
        "Lift_Prpost".editing_time,
        "Lift_Prpost".user,
        "Lift_Prpost".status,

        "Lift_User".id as user_id,
        "Lift_User".first_name,
        "Lift_User".middle_name,
        "Lift_User".second_name,
        "Lift_User".avatar as user_avatar,
        
        "Lift_Project".heading as heading,

        (
            select count(*) from "Lift_Prcommentary"
            where "Lift_Prcommentary".post="Lift_Prpost".id
        ) as commentary_amount,

        (
            select count(*) from "Lift_Prpost_ip"
            where "Lift_Prpost_ip".post="Lift_Prpost".id
        ) as views_amount


        from "Lift_Prpost"
        left join "Lift_User" on("Lift_User".id="Lift_Prpost".user)
        left join "Lift_Project" on("Lift_Project".id="Lift_Prpost".project)

        where "Lift_Prpost".deleted=false ';


        if (!empty($headings)) {
            $headings = implode(',', $headings);
            $query .= " AND \"Lift_Project\".heading IN (" . $headings . ") ";
        }
        

        if(!empty($from))
        {
            $query.=" and \"Lift_Prpost\".creation_time>='".$from."' ";
        }

        if(!empty($to))
        {
            $query.=" and \"Lift_Prpost\".creation_time<='".$to."' ";
        }





        switch ($orderby)
        {
            case "read":
                $query.=' order by views_amount desc ';
                break;
            case "discussed":
                $query.=' order by commentary_amount desc';
                break;
            case "new":
                $query.=' order by "Lift_Prpost".creation_time desc ';
                break;
            case "old":
                $query.=' order by "Lift_Prpost".creation_time asc ';
                break;

            default:
                $query.=' order by "Lift_Prpost".id ';
        };

        if (!empty($limit)) {
            $query .= ' limit ' . $limit;
        }

        if (!empty($offset)) {
            $query .= ' offset '. $offset;
        }
        
        global $connection;
        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);


        return array('success'=>$result);
    }







    function readPrposts_LimitOffset($limit, $offset, $project_id)
    {



        global $connection;

        $query='select
            "Lift_Prpost".id,
            "Lift_Prpost".project,
            "Lift_Prpost".title,
            "Lift_Prpost".text,
            "Lift_Prpost".creation_time,
            "Lift_Prpost".editing_time,
            "Lift_Prpost".user,
            "Lift_Prpost".status,
            "Lift_Prpost".annotation,
            "Lift_Prpost".background,
            "Lift_Prpost".avatar,
            "Lift_Project".heading
            
            from "Lift_Prpost"
            left join "Lift_Project" on ("Lift_Prpost".project="Lift_Project".id)
            where "Lift_Prpost".project='.$project_id.' order by creation_time desc limit '. $limit. ' offset '. $offset;

        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);
//



        return $result;


    }

    function create($token, $data)
    {


        if(empty($data['project'])) $error['data']['project']=true;
        if(empty($data['title'])) $error['data']['title']=true;
        if(empty($data['text'])) $error['data']['text']=true;
        if(empty($data['user'])) $error['data']['user']=true;

        $data['creation_time']=date('Y-m-d H:i:s');
        $data['editing_time']=date('Y-m-d H:i:s');
        //if(empty($data['status'])) $data['status']=0;






        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        };



        $data['creation_time']=date('Y-m-d H:i:s');
        $data['editing_time']=date('Y-m-d H:i:s');




//        echo "<pre>";
//        var_dump($data);
//        die();


//        var_dump($error);
//        die();
        if(empty($error))
        {

            global $connection;



            $result= pg_insert ($connection, get_class($this), $data);




            if(empty($result))
            {

                $error['database']['pg_insert']=true;
                return  array('error'=>$error);

            }
            else
            {

                return array('success'=>$result);
            };

        }
        else
        {
            return array('error'=>$error);
        }

    }

    function amountUser_id($token, $user_id)
    {

        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            global $connection;
            //select * from "Lift_Prpost" where "user"='5';
            //$user_id=5;

            $result=pg_query($connection, 'select * from "'.get_class($this).'" where "user"='.$user_id);
            $result=pg_fetch_row($result);
            //$result=pg_fetch_row($result)[0];
            return $result;
        }

    }


};


class Lift_Tag extends Lift_CRUD
{

};

class Lift_Post_tag extends Lift_CRUD
{

};

class Lift_Commentary extends Lift_CRUD
{


    function getAmountPost($post)
    {

        global $connection;
        $result=pg_query($connection, 'select count(*) as amount from "'.get_class($this).'" where post='.$post);
        $result=pg_fetch_row($result)[0];
        return $result;


    }

    function read($condition)
    {
        global $connection;
        $result=pg_select($connection, get_class($this), $condition);
        return $result[0];
    }
    
    function read_profile($condition)
    {
        global $connection;
        
        $query='
                select

                "Lift_Commentary".id,
                "Lift_Commentary".deleted,
                "Lift_Commentary".parent,
                "Lift_Commentary".post,
                "Lift_Commentary".user,
                "Lift_Commentary".text,
                "Lift_Commentary".creation_time,
                "Lift_Post".title as post_title

                from "Lift_Commentary"

                left join "Lift_Post"
                on ("Lift_Commentary".post="Lift_Post".id)
        
                where "Lift_Commentary".user='.$condition['user'].'
                and "Lift_Commentary".deleted=false
                and "Lift_Post".deleted=false
                order by id asc
        ';

        $result=pg_query($connection, $query);
        $result=pg_fetch_all($result);
        return $result;
    }

    function read_post($condition)
    {

        global $connection;

        $query='


                select

                "Lift_Commentary".id,
                "Lift_Commentary".deleted,
                "Lift_Commentary".parent,
                "Lift_Commentary".post,
                "Lift_Commentary".user,
                "Lift_Commentary".text,
                "Lift_Commentary".creation_time,
                "Lift_User".email,
                "Lift_User".first_name,
                "Lift_User".second_name,
                "Lift_User".middle_name,
                "Lift_User".avatar



                from "Lift_Commentary"

                left join "Lift_User"
                on ("Lift_Commentary".user="Lift_User".id)

                where

                "Lift_Commentary".post=\''.$condition['post'].'\'

                order by id asc


        ';



        $result=pg_query($connection, $query);

        $result=pg_fetch_all($result);

        return $result;


    }

    function getLastId($token, $condition)
    {

        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            global $connection;
            $result=pg_query($connection, 'select MAX(id) from "'.get_class($this).'" where "Lift_Commentary".post='.$condition['post']);
            $result=pg_fetch_all($result);
            return $result[0]['max'];
        };

    }

    function delete($token, $condition)
    {

        if(empty($condition['id'])) $error['condition']['id']=true;
        if(empty($token)) $error['token']=true;
        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        };



        if(empty($error))
        {

            global $connection;

            $data=array
            (
                'deleted'=>true,
            );

            $result= pg_update($connection, get_class($this), $data, $condition);



            if($result)
            {
                return array('success'=>$result);
            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        };

    }

    function create($token, $data)
    {

        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            global $connection;
            $result=pg_insert ($connection, get_class($this), $data);


            if($result)
            {
                return array('success'=>$result);
            }
            else
            {
                $result['error']="pg_insert";
                return array('error'=>$result);
            }
        }
        else
        {
            $error['hasRights']=true;
            return array('error'=>$error);

        };






    }

    function read_LastId($condition)
    {



        global $connection;

        $query='


                select

                "Lift_Commentary".id,
                "Lift_Commentary".deleted,
                "Lift_Commentary".parent,
                "Lift_Commentary".post,
                "Lift_Commentary".user,
                "Lift_Commentary".text,
                "Lift_Commentary".creation_time,
                "Lift_User".email,
                "Lift_User".first_name,
                "Lift_User".middle_name,
                "Lift_User".second_name,
                "Lift_User".avatar

                from "Lift_Commentary"

                left join "Lift_User"
                on ("Lift_Commentary".user="Lift_User".id)

                where

                "Lift_Commentary".id=\''.$condition['id'].'\'

                order by id asc


        ';



        $result=pg_query($connection, $query);

        $result=pg_fetch_all($result);

        return $result;



    }

};




class Lift_Prcommentary extends Lift_CRUD
{

    function read($condition)
    {


        global $connection;

        $query='


                select

                "Lift_Prcommentary".id,
                "Lift_Prcommentary".deleted,
                "Lift_Prcommentary".parent,
                "Lift_Prcommentary".post,
                "Lift_Prcommentary".user,
                "Lift_Prcommentary".text,
                "Lift_Prcommentary".creation_time,
                "Lift_Prpost".title as post_title

                from "Lift_Prcommentary"

                left join "Lift_Prpost"
                on ("Lift_Prcommentary".post="Lift_Prpost".id)

                order by id asc


        ';



        $result=pg_query($connection, $query);

        $result=pg_fetch_all($result);

        return $result;


    }

    function read_post($condition)
    {

        global $connection;

        $query='


                select

                "Lift_Prcommentary".id,
                "Lift_Prcommentary".deleted,
                "Lift_Prcommentary".parent,
                "Lift_Prcommentary".post,
                "Lift_Prcommentary".user,
                "Lift_Prcommentary".text,
                "Lift_Prcommentary".creation_time,
                "Lift_User".email,
                "Lift_User".first_name,
                "Lift_User".second_name,
                "Lift_User".middle_name,
                "Lift_User".avatar

                from "Lift_Prcommentary"

                left join "Lift_User"
                on ("Lift_Prcommentary".user="Lift_User".id)

                where

                "Lift_Prcommentary".post=\''.$condition['post'].'\'

                order by id asc


        ';



        $result=pg_query($connection, $query);

        $result=pg_fetch_all($result);

        return $result;


    }

    function getLastId($token, $condition)
    {

        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            global $connection;
            $result=pg_query($connection, 'select MAX(id) from "'.get_class($this).'" where "Lift_Prcommentary".post='.$condition['post']);
            $result=pg_fetch_all($result);
            return $result[0]['max'];
        };

    }

    function delete($token, $condition)
    {

        if(empty($condition['id'])) $error['condition']['id']=true;
        if(empty($token)) $error['token']=true;
        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        };



        if(empty($error))
        {

            global $connection;

            $data=array
            (
                'deleted'=>true,
            );

            $result= pg_update($connection, get_class($this), $data, $condition);



            if($result)
            {
                return array('success'=>$result);
            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        };

    }

    function create($token, $data)
    {





        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            global $connection;
            $result=pg_insert ($connection, get_class($this), $data);


            if($result)
            {
                return array('success'=>$result);
            }
            else
            {
                $result['error']="pg_insert";
                return array('error'=>$result);
            }
        }
        else
        {
            $error['hasRights']=true;
            return array('error'=>$error);

        };






    }

    function read_LastId($condition)
    {



        global $connection;

        $query='


                select

                "Lift_Prcommentary".id,
                "Lift_Prcommentary".deleted,
                "Lift_Prcommentary".parent,
                "Lift_Prcommentary".post,
                "Lift_Prcommentary".user,
                "Lift_Prcommentary".text,
                "Lift_Prcommentary".creation_time,
                "Lift_User".email,
                "Lift_User".first_name,
                "Lift_User".second_name,
                "Lift_User".middle_name,
                "Lift_User".avatar

                from "Lift_Prcommentary"

                left join "Lift_User"
                on ("Lift_Prcommentary".user="Lift_User".id)

                where

                "Lift_Prcommentary".id=\''.$condition['id'].'\'

                order by id asc


        ';



        $result=pg_query($connection, $query);

        $result=pg_fetch_all($result);

        return $result;



    }

};




class Lift_Tskcommentary extends Lift_CRUD
{

    function read($condition)
    {
        global $connection;
        return pg_select($connection, get_class($this), $condition);
    }

    function read_task($condition)
    {

        global $connection;

        //var_dump($condition);
        //die();

        $query='
                select
                "Lift_Tskcommentary".id,
                "Lift_Tskcommentary".deleted,
                "Lift_Tskcommentary".parent,
                "Lift_Tskcommentary".task,
                "Lift_Tskcommentary".user,
                "Lift_Tskcommentary".text,
                "Lift_Tskcommentary".creation_time,
                "Lift_User".email,
                "Lift_User".first_name,
                "Lift_User".second_name,
                "Lift_User".middle_name,
                "Lift_User".avatar

                from "Lift_Tskcommentary"
                left join "Lift_User"
                on ("Lift_Tskcommentary".user="Lift_User".id)

                where
                "Lift_Tskcommentary".task=\''.$condition['task'].'\'
                order by id asc




        ';



        $result=pg_query($connection, $query);

        $result=pg_fetch_all($result);

//        var_dump($result);
//        die();

        return $result;


    }

    function getLastId($token, $condition)
    {

        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            global $connection;
            $result=pg_query($connection, 'select MAX(id) from "'.get_class($this).'" where "Lift_Tskcommentary".task='.$condition['task']);
            $result=pg_fetch_all($result);
            return $result[0]['max'];
        };

    }

    function delete($token, $condition)
    {

        if(empty($condition['id'])) $error['condition']['id']=true;
        if(empty($token)) $error['token']=true;
        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        };



        if(empty($error))
        {

            global $connection;

            $data=array
            (
                'deleted'=>true,
            );

            $result= pg_update($connection, get_class($this), $data, $condition);



            if($result)
            {
                return array('success'=>$result);
            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        };

    }

    function create($token, $data)
    {




//        echo "<pre>";
//        var_dump($data);
//        die();


        if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            global $connection;
            $result=pg_insert ($connection, get_class($this), $data);


            if($result)
            {
                return array('success'=>$result);
            }
            else
            {
                $result['error']="pg_insert";
                return array('error'=>$result);
            }
        }
        else
        {
            $error['hasRights']=true;
            return array('error'=>$error);

        };






    }

    function read_LastId($condition)
    {



//
//        var_dump($condition);
//        die();
//
        global $connection;

        $query='


                select

                "Lift_Tskcommentary".id,
                "Lift_Tskcommentary".deleted,
                "Lift_Tskcommentary".parent,
                "Lift_Tskcommentary".task,
                "Lift_Tskcommentary".user,
                "Lift_Tskcommentary".text,
                "Lift_Tskcommentary".creation_time,
                "Lift_User".email,
                "Lift_User".first_name,
                "Lift_User".second_name,
                "Lift_User".middle_name,
                "Lift_User".avatar

                from "Lift_Tskcommentary"

                left join "Lift_User"
                on ("Lift_Tskcommentary".user="Lift_User".id)

                where

                "Lift_Tskcommentary".id=\''.$condition['id'].'\'

                order by id asc


        ';



        $result=pg_query($connection, $query);

        $result=pg_fetch_all($result);

        return $result;



    }

};



class Lift_Task_access extends Lift_CRUD
{


    function read( $condition)
    {

        //if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            global $connection;
            return pg_select($connection, get_class($this), $condition);

        };


    }

    function delete($token, $condition)
    {


        if(empty($token)) $error['token']=true;

        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        }

        if(empty($error))
        {
            global $connection;
            $result= pg_delete($connection, get_class($this), $condition);




            if($result)
            {
                $result['success']=$result;
                return array('success'=>$result);


            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        }

    }

};




class Lift_Blog_access extends Lift_CRUD
{
    function create($token, $data)
    {
        // if($token && Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        // {
            global $connection;
            return pg_insert ($connection, 'Lift_Blog_access', $data);
        // }
    }


    function read( $condition)
    {

        // if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        // {

            global $connection;
            return pg_select($connection, get_class($this), $condition);

        // };


    }

    function delete($token, $condition)
    {


        if(empty($token)) $error['token']=true;

        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        }

        if(empty($error))
        {
            global $connection;
            $result= pg_delete($connection, get_class($this), $condition);




            if($result)
            {
                $result['success']=$result;
                return array('success'=>$result);


            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        }

    }

};



class Lift_Project_access extends Lift_CRUD
{


    function read($condition)
    {
        //if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            global $connection;
            return pg_select($connection, get_class($this), $condition);
        };
    }

    function delete($token, $condition)
    {


        if(empty($token)) $error['token']=true;

        if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {
            $error['hasRights']=true;
        }

        if(empty($error))
        {
            global $connection;
            $result= pg_delete($connection, get_class($this), $condition);




            if($result)
            {
                $result['success']=$result;
                return array('success'=>$result);


            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        }

    }

};



class Lift_Badge_type extends Lift_CRUD
{

};

class Lift_Badge extends Lift_CRUD
{

};

class Lift_Curators_resume extends Lift_CRUD
{

};

class Lift_Site extends Lift_CRUD
{

};

class Lift_Page extends Lift_CRUD
{
    function read( $condition)
    {



            global $connection;
            return pg_select($connection, get_class($this), $condition);

    }


};

class Lift_Media_file extends Lift_CRUD
{

};

class Lift_Media_page extends Lift_CRUD
{

};

class Lift_Media_post extends Lift_CRUD
{

};


class Lift_Post_ip extends Lift_CRUD
{

    function create( $data)
    {
            global $connection;
            return pg_insert ($connection, get_class($this), $data);

    }

    function amountOfViews($post_id)
    {

        global $connection;


        $query='select distinct
            count(*)
            from "Lift_Post_ip"
            where
            "Lift_Post_ip".post='.$post_id;

        $result=pg_query($connection, $query);
        $result=pg_fetch_row($result)[0];




        return $result;
    }

};

class Lift_Prpost_ip extends Lift_CRUD
{

    function create( $data)
    {
        global $connection;
        return pg_insert ($connection, get_class($this), $data);

    }

    function amountOfViews($post_id)
    {

        global $connection;


        $query='select distinct
            count(*)
            from "Lift_Prpost_ip"
            where
            "Lift_Prpost_ip".post='.$post_id;

        $result=pg_query($connection, $query);
        $result=pg_fetch_row($result)[0];


        return $result;
    }

};


class Lift_Blog_Heading extends Lift_CRUD
{

    function create( $data)
    {
        global $connection;
        return pg_insert ($connection, get_class($this), $data);

    }

    function delete( $condition)
    {




        if(empty($error))
        {
            global $connection;
            $result= pg_delete($connection, get_class($this), $condition);
//            var_dump($result);
//            die();




            if($result)
            {
                $result['success']=$result;
                return array('success'=>$result);


            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        }

    }

    function read( $condition)
    {

        //if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            global $connection;
            return pg_select($connection, get_class($this), $condition);

        };

    }

};

class Lift_Post_Heading extends Lift_CRUD
{

    function create( $data)
    {
        global $connection;
        return pg_insert ($connection, get_class($this), $data);

    }

    function delete( $condition)
    {


        //if(empty($token)) $error['token']=true;
//    if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
//    {
//        $error['hasRights']=true;
//    }


        if(empty($error))
        {
            global $connection;
            $result= pg_delete($connection, get_class($this), $condition);




            if($result)
            {
                $result['success']=$result;
                return array('success'=>$result);


            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        }

    }

    function read( $condition)
    {

        //if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            global $connection;

            return pg_select($connection, get_class($this), $condition);


        };

    }

};


class Lift_Blog_Subject extends Lift_CRUD
{

    function create( $data)
    {
        global $connection;
        return pg_insert ($connection, get_class($this), $data);

    }

    function delete( $condition)
    {


        //if(empty($token)) $error['token']=true;
//    if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
//    {
//        $error['hasRights']=true;
//    }


        if(empty($error))
        {
            global $connection;
            $result= pg_delete($connection, get_class($this), $condition);




            if($result)
            {
                $result['success']=$result;
                return array('success'=>$result);


            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        }

    }

    function read( $condition)
    {

        //if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            global $connection;
            return pg_select($connection, get_class($this), $condition);

        };

    }

};



class Lift_Blog_Follow extends Lift_CRUD
{

}

class Lift_Post_Subject extends Lift_CRUD
{

    function create( $data)
    {
        global $connection;
        return pg_insert ($connection, get_class($this), $data);

    }

    function delete( $condition)
    {


        //if(empty($token)) $error['token']=true;
//    if(!Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
//    {
//        $error['hasRights']=true;
//    }


        if(empty($error))
        {
            global $connection;
            $result= pg_delete($connection, get_class($this), $condition);




            if($result)
            {
                $result['success']=$result;
                return array('success'=>$result);


            }
            else
            {
                $error['database']['pg_delete']=true;
                return array('error'=>$error);
            }

        }
        else
        {
            return array('error'=>$error);
        }

    }


    function read( $condition)
    {

        //if(Lift_Token::hasRights($token, get_class($this), __FUNCTION__))
        {

            global $connection;
            return pg_select($connection, get_class($this), $condition);

        };

    }

};





