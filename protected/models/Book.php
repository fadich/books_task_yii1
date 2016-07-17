<?php

/**
 * This is the model class for table "book".
 *
 * The followings are the available columns in table 'book':
 * @property integer $id
 * @property string $name
 * @property integer $date_create
 * @property integer $date_update
 * @property string $preview
 * @property integer $date
 * @property integer $author_id
 * @property integer $status
 */
class Book extends CActiveRecord
{
    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 10;

    public $image;
    public $filterName;
    public $filterAuthor;
    public $filterDateSince;
    public $filterDateTo;
    public $filterDateSinceSub;
    public $filterDateToSub;
    public $limit;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Book the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'book';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, date, author_id', 'required'),
            array('status, date_create, date_update, author_id, filterAuthor, filterDateSince, filterDateTo,
            filterDateSinceSub, filterDateToSub, limit',
                'numerical', 'integerOnly' => true),
            array('name, date, preview, filterName', 'length', 'max' => 255, 'min' => 6),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, date_create, date_update, preview, date, author_id', 'safe', 'on' => 'search'),
            array('image', 'safe'),
            array('image', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Название',
            'date_create' => 'Дата добавления',
            'preview' => 'Превью',
            'image' => 'Превью (картинка)',
            'date' => 'Дата выхода книги',
            'author_id' => 'Автор',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('date_create', $this->date_create);
        $criteria->compare('date_update', $this->date_update);
        $criteria->compare('preview', $this->preview, true);
        $criteria->compare('date', $this->date);
        $criteria->compare('author_id', $this->author_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param Book $book
     * @return bool
     */
    public function updateBook(Book $book)
    {
        $book->name = $this->name;
        $book->author_id = $this->author_id;
        $book->date_create = $this->date_create === null ? time() : $this->date_create;
        $book->date_update = time();
        $book->preview = $this->preview;
        $this->date = str_replace('/', '-', $this->date);
        $book->date = strtotime($this->date);
        $book->status = self::STATUS_ACTIVE;

        return $book->save() ? true : false;
    }

    public function getAuthor()
    {
        $author = Author::model()->findByPk($this->author_id);
        return $author;
    }

    /**
     * @return bool
     */
    public function deleteBook()
    {
        $this->status = self::STATUS_NOT_ACTIVE;
        return $this->save() ? true : false;
    }
}