<?php

class QuestionsController extends AppController {

    var $name = 'Questions';

    /**
     * @var Question */
    var $Question;
    

    function admin_view($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid question', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('question', $this->Question->read(null, $id));
    }


    function index($course_id = false) {
        $this->admin_index($course_id);
        $this->render("admin_index");
    }

    function admin_index($course_id = false) {
        
        //$this->Question->recursive = 0;
        $conditions = array("Question.course_id" => $course_id,'Question.quiz_status < '=>1);
        $this->set('questions', $this->paginate($conditions));
        //to send it to view admin_index
        $this->set('course_id',$course_id);
        
        
        $this->loadModel("Course");
        $course = $this->Course->findById($course_id);
        //to send it to view admin_edit
        $this->set('course',$course);

        
    }

    function add($course_id = false) {
        $this->admin_add($course_id);
        $this->render("admin_add");
    }

    function admin_add($course_id = false) {

        //to send it to view admin_add
        $this->set('course_id',$course_id);
        
        $this->data["Question"]["course_id"];
        
        //$this->Question->Exam->recursive = -1;
//        if (isset($this->data["Question"]["course_id"])) {
//            $exam_id = $this->data["Question"]["course_id"];
//        }

        $this->loadModel("QuestionChoice");
        $this->loadModel("QuestionColumn");
        

        if (!empty($this->data)) {
            $question_type = $this->data["Question"]["question_type"];

            // <editor-fold defaultstate="collapsed"  desc="Check data vlidation for choices "> 

            if (!empty($this->data["QuestionChoice"])) {
                $question_choices = $this->data["QuestionChoice"];
                $points = 0;
                foreach ($question_choices as $i => $choice) {
                    if (isset($choice["points"]) && !is_numeric($choice["points"])) {
                        $error = true;
                        $this->QuestionChoice->validationErrors[$i]["points"] = __("Must be numeric", true);
                    } else {
                        if ($question_type == "multiple" && $choice["points"] > 0) {
                            $points+=$choice["points"];
                        } elseif ($choice["points"] > $points) {
                            $points = $choice["points"];
                        }
                    }

                    if (isset($choice["c_order"]) && !is_numeric($choice["c_order"])) {
                        $error = true;
                        $this->QuestionChoice->validationErrors[$i]["c_order"] = __("Must be numeric", true);
                    }

                    if (empty($choice["body"])) {
                        $error = true;
                        $this->QuestionChoice->validationErrors[$i]["body"] = __("Required", true);
                    }
                }

                if (isset($this->data["Question"]["points"]) && $this->data["Question"]["points"] > 0)
                    $points = $this->data["Question"]["points"];

                if ($points == 0 && empty($this->QuestionChoice->validationErrors)) {
                    $error = true;
                    $error_message = __("Total grade must be more than 0", true);
                    foreach ($question_choices as $i => $choice) {
                        $this->QuestionChoice->validationErrors[$i]["points"] = "";
                    }
                }

                $this->data["Question"]["points"] = $points;
            }
            //</editor-fold>
            // <editor-fold defaultstate="collapsed"  desc="Check data vlidation for QuestionColumn "> 

            if (!empty($this->data["QuestionColumn"])) {
                $question_columns = $this->data["QuestionColumn"];
                $points = 0;
                foreach ($question_columns as $i => $column) {
                    $cat_choices = $column["QuestionChoice"];
                    foreach ($cat_choices as $j => $choice) {
                        if (isset($choice["points"]) && !is_numeric($choice["points"])) {
                            $error = true;
                            $this->QuestionColumn->validationErrors[$i]["QuestionChoice"][$j]["points"] = __("Must be numeric", true);
                        } else {
                            $points+=$choice["points"];
                        }
                        if (empty($choice["body"])) {
                            $error = true;
                            $this->QuestionColumn->validationErrors[$i]["QuestionChoice"][$j]["body"] = __("Required", true);
                        }
                    }

                    if (empty($choice["body"])) {
                        $error = true;
                        $this->QuestionColumn->validationErrors[$i]["body"] = __("Required", true);
                    }
                }

                if (isset($this->data["Question"]["points"]) && $this->data["Question"]["points"] > 0) {
                    $points = $this->data["Question"]["points"];
                } elseif ($points == 0 && empty($this->QuestionColumn->validationErrors)) {
                    $error = true;
                    $error_message = __("Total grade must be more than 0", true);
                    foreach ($question_columns as $i => $column) {
                        $cat_choices = $column["QuestionChoice"];
                        foreach ($cat_choices as $j => $choice) {
                            $this->QuestionColumn->validationErrors[$i]["QuestionChoice"][$j]["points"] = "";
                        }
                    }
                }
                $this->data["Question"]["points"] = $points;
            }

            //</editor-fold>
            
            //#################################################

            $error = false;
            
            if (!$error) {
                /*
                if (!$this->data["Question"]["points"] && $question_type != "content_only") {
                    $this->Question->validationErrors["points"] = "Must be more than 0";
                }
                 * 
                 */
                $this->Question->create();
                if($this->data["Question"]["question_type"]=="image"){
                  
                      $data=$this->data['Question']['image'];
                      $temp = $data['tmp_name'];
                    $file_name = substr(md5(rand(1, 213213212)), 1, 5) . "_" . $data['name'];
                    $file_name = str_replace(array('\'', '"', ' ', '`'), '_', $file_name);
                    $temp_dir = dirname($temp);
                    $FileName = WEBROOT_DIR . DIRECTORY_SEPARATOR . $file_name;
                    $ext = substr(strtolower(strrchr($data['name'], '.')), 1); //get the extension
                    $arr_ext = array('jpg', 'jpeg', 'gif'); //set allowed extensions
                    $uploadPath = WWW_ROOT . 'uploads' . DIRECTORY_SEPARATOR . 'questions' . DIRECTORY_SEPARATOR.$file_name;
                    set_time_limit(180000);
                    
                                        if (move_uploaded_file($temp, $uploadPath)) {
                                            $this->data["Question"]['image']=$file_name;
                                        }else{
                                            $this->setFlash(__("The image hasn't been uploaded", true), 'alert alert-success');
                                        }
                        // store the filename in the array to be saved to the db
                        
                    
                }
                
                if ($this->Question->save($this->data)) {
                    debug($this->data);
                    if (!empty($question_choices)) {
                        foreach ($question_choices as $choice) {
                            $choice["question_id"] = $this->Question->id;
                            $data = array("QuestionChoice" => $choice);
                            $this->QuestionChoice->create();
                            $this->QuestionChoice->save($data);
                        }
                    }
                    if (!empty($question_columns)) {
                        foreach ($question_columns as $column) {
                            $column["question_id"] = $this->Question->id;
                            $data = array("QuestionColumn" => $column);
                            $this->QuestionColumn->create();
                            if ($this->QuestionColumn->save($data)) {
                                if (!empty($column["QuestionChoice"])) {
                                    $cat_choices = $column["QuestionChoice"];
                                    foreach ($cat_choices as $j => $choice) {
                                        $choice["question_id"] = $this->Question->id;
                                        $choice["question_column_id"] = $this->QuestionColumn->id;
                                        $data = array("QuestionChoice" => $choice);
                                        $this->QuestionChoice->create();
                                        $this->QuestionChoice->save($data);
                                    }
                                }
                            }
                        }
                    }
                    $this->setFlash(__('The question has been saved', true), 'alert alert-success');
                    //$this->redirect(array('action' => 'index', $exam_id));
                    $this->redirect(array('action' => 'index',$course_id));
                } else {
                    $this->setFlash(__('The question could not be saved. Please, try again.', true), 'alert alert-danger');
                }
            } else {
                if (isset($error_message))
                    $this->setFlash($error_message, 'alert alert-danger');
                else
                    $this->setFlash(__('Please complete required fields, try again.', true), 'alert alert-danger');
            }

            
        }

      
        $this->data["Question"]["course_id"] = $course_id;
        //$course_id = $question["Question"]["course_id"];
        $this->loadModel("Course");
        $course = $this->Course->findById($course_id);
        //to send it to view admin_edit
        $this->set('course',$course);
        
    }

    
//############################ edit ##################################
    function edit($id = false) {
        $this->admin_edit($id);
        $this->render("admin_edit");
    }

    function admin_edit($id = null) {

        //$id da q id 
        //$this->set(compact('course'));

        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid question', true), 'fail');
            $this->redirect(array('action' => 'index'));
        }
        $question = $this->Question->read(null, $id);
        $this->set("question", $question);
        //$this->Question->Exam->recursive = -1;
        //$exam_id = $question["Question"]["exam_id"];
        $this->loadModel("QuestionChoice");
        $this->loadModel("QuestionColumn");
        //$exam = $this->Question->Exam->findById($exam_id);
        /*
          if (!$exam) {
          $this->setFlash(__('Exam not found', true), 'alert alert-danger');
          $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
          }
          $this->get_course($exam["Exam"]["course_id"]);
          $total_forexam = $this->Question->find("first", array("fields" => array("SUM(points) as total_points"), "conditions" => array("Question.exam_id" => $exam_id, "NOT" => array("Question.id" => $id))));
          $exam["Exam"]["total"] = $total_forexam[0]["total_points"];
          $exam["Exam"]["remain"] = $exam["Exam"]["grade"] - $total_forexam[0]["total_points"];
          if ($exam["Exam"]["remain"] <= 0) {
          $this->setFlash(__('There is no remain points for this exam to create new question', true), 'alert');
          //$this->redirect(array('action' => 'index', $exam_id));
          }
          $this->set('exam', $exam);

         */
        if (!empty($this->data)) {
            $this->data["Question"]["id"] = $id;

            $question_type = $this->data["Question"]["question_type"];
            // <editor-fold defaultstate="collapsed"  desc="Check data vlidation for choices "> 

            if (!empty($this->data["QuestionChoice"])) {
                $question_choices = $this->data["QuestionChoice"];
                $ch_ids = Set::combine($question_choices, "{n}.id", "{n}.id");
                $points = 0;
                foreach ($question_choices as $i => $choice) {
                    if (isset($choice["points"]) && !is_numeric($choice["points"])) {
                        $error = true;
                        $this->QuestionChoice->validationErrors[$i]["points"] = __("Must be numeric", true);
                    } else {
                        if ($question_type == "multiple" && $choice["points"] > 0) {
                            $points+=$choice["points"];
                        } elseif ($choice["points"] > $points) {
                            $points = $choice["points"];
                        }
                    }

                    if (isset($choice["c_order"]) && !is_numeric($choice["c_order"])) {
                        $error = true;
                        $this->QuestionChoice->validationErrors[$i]["c_order"] = __("Must be numeric", true);
                    }

                    if (empty($choice["body"])) {
                        $error = true;
                        $this->QuestionChoice->validationErrors[$i]["body"] = __("Required", true);
                    }
                }

                if (isset($this->data["Question"]["points"]) && $this->data["Question"]["points"] > 0)
                    $points = $this->data["Question"]["points"];

                if ($points == 0 && empty($this->QuestionChoice->validationErrors)) {
                    $error = true;
                    $error_message = __("Total grade must be more than 0", true);
                    foreach ($question_choices as $i => $choice) {
                        $this->QuestionChoice->validationErrors[$i]["points"] = "";
                    }
                }



                $this->data["Question"]["points"] = $points;
            }
            //</editor-fold>
            // <editor-fold defaultstate="collapsed"  desc="Check data vlidation for QuestionColumn "> 

            if (!empty($this->data["QuestionColumn"])) {
                $question_columns = $this->data["QuestionColumn"];
                $points = 0;
                foreach ($question_columns as $i => $column) {
                    $cat_choices = $column["QuestionChoice"];
                    foreach ($cat_choices as $j => $choice) {
                        if (isset($choice["points"]) && !is_numeric($choice["points"])) {
                            $error = true;
                            $this->QuestionColumn->validationErrors[$i]["QuestionChoice"][$j]["points"] = __("Must be numeric", true);
                        } else {
                            $points+=$choice["points"];
                        }
                        if (empty($choice["body"])) {
                            $error = true;
                            $this->QuestionColumn->validationErrors[$i]["QuestionChoice"][$j]["body"] = __("Required", true);
                        }
                    }
                    if (empty($choice["body"])) {
                        $error = true;
                        $this->QuestionColumn->validationErrors[$i]["body"] = __("Required", true);
                    }
                }


                if (isset($this->data["Question"]["points"]) && $this->data["Question"]["points"] > 0) {
                    $points = $this->data["Question"]["points"];
                } elseif ($points == 0 && empty($this->QuestionColumn->validationErrors)) {
                    $error = true;
                    $error_message = __("Total grade must be more than 0", true);
                    foreach ($question_columns as $i => $column) {
                        $cat_choices = $column["QuestionChoice"];
                        foreach ($cat_choices as $j => $choice) {
                            $this->QuestionColumn->validationErrors[$i]["QuestionChoice"][$j]["points"] = "";
                        }
                    }
                }
                $this->data["Question"]["points"] = $points;
            }

            //</editor-fold>

            /*
              if ($this->data["Question"]["points"] > $exam["Exam"]["remain"]) {
              $error = true;
              $error_message = __("Total grade must be less than remain points for this exam", true);
              foreach ($question_choices as $i => $choice) {
              $this->QuestionChoice->validationErrors[$i]["points"] = "";
              }
              }

             */
            $error = false;

            if (!$error) {
                if (!$this->data["Question"]["points"] && $question_type != "content_only") {
                    $this->Question->validationErrors["points"] = "Must be more than 0";
                }
                
                /*
                $this->Question->saveAll($this->data);
                $this->setFlash(__('The question has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', $question["Question"]["course_id"]));
                */
                
                
                
                if ($this->Question->saveAll($this->data)) {
                    
                    if (!empty($question_choices)) {
                        $this->loadModel("QuestionChoice");
                        $this->QuestionChoice->deleteAll(array("QuestionChoice.question_id" => $id, array("NOT" => array("QuestionChoice.id" => $ch_ids))));
                        foreach ($question_choices as $choice) {
                            $choice["question_id"] = $this->Question->id;
                            $data = array("QuestionChoice" => $choice);
                            $this->QuestionChoice->create();
                            $this->QuestionChoice->save($data);
                        }
                    }

                    if (!empty($question_columns)) {
                        $co_ids = Set::combine($question_columns, "{n}.id", "{n}.id");
                        $this->QuestionColumn->deleteAll(array("QuestionColumn.question_id" => $this->Question->id, array("NOT" => array("QuestionColumn.id" => $co_ids))), false);
                        $this->QuestionChoice->deleteAll(array("QuestionChoice.question_id" => $this->QuestionColumn->id, array("NOT" => array("QuestionChoice.question_column_id" => $co_ids))), false);

                        foreach ($question_columns as $column) {
                            $column["question_id"] = $this->Question->id;
                            $data = array("QuestionColumn" => $column);
                            if ($this->QuestionColumn->save($data)) {
                                $ch_ids = Set::combine($column["QuestionChoice"], "{n}.id", "{n}.id");
                                $this->QuestionChoice->deleteAll(array("QuestionChoice.question_column_id" => $this->QuestionColumn->id, array("NOT" => array("QuestionChoice.id" => $ch_ids))));
                                if (!empty($column["QuestionChoice"])) {
                                    $cat_choices = $column["QuestionChoice"];
                                    foreach ($cat_choices as $j => $choice) {
                                        $choice["question_id"] = $this->Question->id;
                                        $choice["question_column_id"] = $this->QuestionColumn->id;
                                        $data = array("QuestionChoice" => $choice);
                                        $this->QuestionChoice->save($data);
                                    }
                                }
                            }
                        }
                    }
                    $this->setFlash(__('The question has been saved', true), 'alert alert-success');
                    $this->redirect(array('action' => 'index', $question["Question"]["course_id"]));
                } else {
                    $this->setFlash(__('The question could not be saved. Please, try again.', true), 'alert alert-danger');
                }
            } else {
                if (isset($error_message))
                    $this->setFlash($error_message, 'alert alert-danger');
                else
                    $this->setFlash(__('Please complete required fields, try again.', true), 'alert alert-danger');
            
            }
 
        }//! empty
        
        if (empty($this->data)) {
            if (in_array($question["Question"]["question_type"], array("category_choice", "category_drag"))) {
                $choices = Set::combine($question["QuestionChoice"], "{n}.id", "{n}", "{n}.question_column_id");
                $columns = Set::combine($question["QuestionColumn"], "{n}.id", "{n}");
                foreach ($columns as $id => $column) {
                    if (isset($choices[$id])) {
                        $columns[$id]["QuestionChoice"] = $choices[$id];
                    }
                }
                $question["QuestionColumn"] = $columns;
                unset($question["QuestionChoice"]);
            }
            $this->data = $question;
        }

        $course_id = $question["Question"]["course_id"];
        $this->loadModel("Course");
        $course = $this->Course->findById($course_id);
        //to send it to view admin_edit
        $this->set('course', $course);
    }


    //################################# delete okk #####################################

    function delete($id = null) {
        $this->admin_delete($id);
    }

    function admin_delete($id = null) {
        $this->Question->recursive = -1;
        $question = $this->Question->read(null, $id);
        $course_id = $question["Question"]["course_id"];
        
        if (!$id) {
            $this->setFlash(__('Invalid id for question', true), 'fail');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Question->delete($id)) {
            $this->setFlash(__('Question deleted', true), 'success');
            $this->redirect(array('action' => 'index', $course_id));
        }
        $this->setFlash(__('Question was not deleted', true), 'fail');
        $this->redirect(array('action' => 'index', $course_id));
    }

//#############################################################################
     function preview($id = null) {
         $this->loadModel("Course");
         $this->loadModel("QuestionChoice");
         $this->loadModel("QuestionColumn");
         
        $this->Question->recursive = -1;
       
         
        $question = $this->Question->read(null, $id);
        $course_id = $question["Question"]["course_id"];
        $this->set("course_id", $course_id);
         
        $question_info = $this->Question->find("first", array("conditions" => array("Question.id" => $id)));
        $this->set("question_info", $question_info);
        
        //debug($question_info);
        
        $question_ch = $this->QuestionChoice->find("list", array("conditions" => array("QuestionChoice.question_id" => $id)));
        $this->set("question_ch", $question_ch);
        
        //debug($question_ch);
        
        $question_col = $this->QuestionColumn->find("list", array("conditions" => array("QuestionColumn.question_id" => $id)));
        $this->set("question_col", $question_col);
        
        ////////////////////////////
        
        
        
        $question_ch_matrix = $this->QuestionChoice->find("all", array("fields"=>"QuestionChoice.id,QuestionChoice.body,QuestionChoice.question_column_id","conditions" => array("QuestionChoice.question_id" => $id)));
        $this->set("question_ch_matrix", $question_ch_matrix);
        
        //debug($question_ch);
        
        $question_col_matrix = $this->QuestionColumn->find("all", array("fields"=>"QuestionColumn.id,QuestionColumn.body","conditions" => array("QuestionColumn.question_id" => $id)));
        
        $this->set("question_col_matrix", $question_col_matrix);
        
        
        //debug($question_col);
   
     }
//#############################################################################
   function admin_do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        if ($operation == 'delete') {
            if ($this->Question->deleteAll(array('Question.id' => $ids))) {
                $this->setFlash('Page deleted alert alert-successfully', 'alert alert-success');
            } else {
                $this->setFlash('Page can not be deleted', 'alert alert-danger');
            }
        }
        $this->redirect(array('action' => 'index'));
    }
    function do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        if ($operation == 'delete') {
            if ($this->Question->deleteAll(array('Question.id' => $ids))) {
                $this->setFlash('Page deleted alert alert-successfully', 'alert alert-success');
            } else {
                $this->setFlash('Page can not be deleted', 'alert alert-danger');
            }
        }
        $this->redirect(array('action' => 'index'));
    }
     

//#####################################  quiz  ##########################################
    
       function quiz_question_index($course_id = false) {
        
        //$this->Question->recursive = 0;
        $conditions = array("Question.course_id" => $course_id,'Question.quiz_status=1');
        $this->set('questions', $this->paginate($conditions));
        //to send it to view admin_index
        $this->set('course_id',$course_id);
        
        
        $this->loadModel("Course");
        $course = $this->Course->findById($course_id);
        //to send it to view admin_edit
        $this->set('course',$course);
        $this->set('level',$_GET['level']);

        /*
          $this->Question->Exam->recursive = -1;

          $exam = $this->Question->Exam->findById($course_id);
          if (!$exam) {
          $this->setFlash(__('Exam not found', true), 'alert alert-danger');
          $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
          }
          $this->get_course($exam["Exam"]["course_id"]);
          $this->set('exam', $exam);
         * 
         */
    }
    
    
    function quiz_question_add($course_id = false) {

        //to send it to view admin_add
        $this->set('course_id',$course_id);
        
        $this->data["Question"]["course_id"];
        
        //$this->Question->Exam->recursive = -1;
//        if (isset($this->data["Question"]["course_id"])) {
//            $exam_id = $this->data["Question"]["course_id"];
//        }

        $this->loadModel("QuestionChoice");
        $this->loadModel("QuestionColumn");
        

        if (!empty($this->data)) {
            $question_type = $this->data["Question"]["question_type"];

            // <editor-fold defaultstate="collapsed"  desc="Check data vlidation for choices "> 

            if (!empty($this->data["QuestionChoice"])) {
                $question_choices = $this->data["QuestionChoice"];
                $points = 0;
                foreach ($question_choices as $i => $choice) {
                    if (isset($choice["points"]) && !is_numeric($choice["points"])) {
                        $error = true;
                        $this->QuestionChoice->validationErrors[$i]["points"] = __("Must be numeric", true);
                    } else {
                        if ($question_type == "multiple" && $choice["points"] > 0) {
                            $points+=$choice["points"];
                        } elseif ($choice["points"] > $points) {
                            $points = $choice["points"];
                        }
                    }

                    if (isset($choice["c_order"]) && !is_numeric($choice["c_order"])) {
                        $error = true;
                        $this->QuestionChoice->validationErrors[$i]["c_order"] = __("Must be numeric", true);
                    }

                    if (empty($choice["body"])) {
                        $error = true;
                        $this->QuestionChoice->validationErrors[$i]["body"] = __("Required", true);
                    }
                }

                if (isset($this->data["Question"]["points"]) && $this->data["Question"]["points"] > 0)
                    $points = $this->data["Question"]["points"];

                if ($points == 0 && empty($this->QuestionChoice->validationErrors)) {
                    $error = true;
                    $error_message = __("Total grade must be more than 0", true);
                    foreach ($question_choices as $i => $choice) {
                        $this->QuestionChoice->validationErrors[$i]["points"] = "";
                    }
                }

                $this->data["Question"]["points"] = $points;
            }
            //</editor-fold>
            
            
            //#################################################

            /*
              if ($this->data["Question"]["points"] > $exam["Exam"]["remain"]) {
              $error = true;
              $error_message = __("Total grade must be less than remain points for this exam", true);

              }
             */
            $error = false;
            
            if (!$error) {
                /*
                if (!$this->data["Question"]["points"] && $question_type != "content_only") {
                    $this->Question->validationErrors["points"] = "Must be more than 0";
                }
                 * 
                 */
                $this->Question->create();
                $this->data['Question']['quiz_status']=1;
                $this->data['Question']['level_id']=$_GET['level'];
                if ($this->Question->save($this->data)) {
                    if (!empty($question_choices)) {
                        foreach ($question_choices as $choice) {
                            $choice["question_id"] = $this->Question->id;
                            $data = array("QuestionChoice" => $choice);
                            $this->QuestionChoice->create();
                            $this->QuestionChoice->save($data);
                        }
                    }
                   
                    $this->setFlash(__('The question has been saved', true), 'alert alert-success');
                    //$this->redirect(array('action' => 'index', $exam_id));
                    $this->redirect(array('action' => 'quiz_question_index',$course_id,'?'=>array('level'=>$_GET["level"])));
                } else {
                    $this->setFlash(__('The question could not be saved. Please, try again.', true), 'alert alert-danger');
                }
            } else {
                if (isset($error_message))
                    $this->setFlash($error_message, 'alert alert-danger');
                else
                    $this->setFlash(__('Please complete required fields, try again.', true), 'alert alert-danger');
            }

            //</editor-fold>
        }

        //$this->data["Question"]["exam_id"] = $exam_id;
        //$this->data["Question"]["course_id"] = $exam["Exam"]["course_id"];
        //$this->data["Question"]["level_id"] = $exam["Exam"]["level_id"];
        
        $this->data["Question"]["course_id"] = $course_id;
        //$course_id = $question["Question"]["course_id"];
        $this->loadModel("Course");
        $course = $this->Course->findById($course_id);
        //to send it to view admin_edit
        $this->set('course',$course);
        $this->set('level',$_GET['level']);
        
    }
   
    function quiz_question_delete($id = null) {
        $this->Question->recursive = -1;
        $question = $this->Question->read(null, $id);
        $course_id = $question["Question"]["course_id"];
        $this->set('level',$_GET['level']);
        if (!$id) {
            $this->setFlash(__('Invalid id for question', true), 'fail');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Question->delete($id)) {
            $this->setFlash(__('Question deleted', true), 'success');
            $this->redirect(array('action' => 'quiz_question_index', $course_id, '?' => array('level' => $_GET['level'])));
        }
        $this->setFlash(__('Question was not deleted', true), 'fail');
        $this->redirect(array('action' => 'quiz_question_index', $course_id, '?' => array('level' => $_GET['level'])));
    }   




}//class 

