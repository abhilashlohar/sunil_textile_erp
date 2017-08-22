<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Inwards Model
 *
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\StockJournalsTable|\Cake\ORM\Association\BelongsTo $StockJournals
 *
 * @method \App\Model\Entity\Inward get($primaryKey, $options = [])
 * @method \App\Model\Entity\Inward newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Inward[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Inward|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Inward patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Inward[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Inward findOrCreate($search, callable $callback = null, $options = [])
 */
class InwardsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('inwards');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('StockJournals', [
            'foreignKey' => 'stock_journal_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->decimal('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

        $validator
            ->decimal('rate')
            ->requirePresence('rate', 'create')
            ->notEmpty('rate');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['stock_journal_id'], 'StockJournals'));

        return $rules;
    }
}
