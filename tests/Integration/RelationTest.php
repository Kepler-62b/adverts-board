<?php
declare(strict_types=1);

namespace Tests\Integration;

use Framework\Services\Relation;
use PHPUnit\Framework\TestCase;

final class RelationTest extends TestCase
{

    public static function toTestGetRepositoryDataProvider(): array
    {
        return
            [
                'ImageModel' => [
                    'databaseName' => 'Dev\trash\MySQLAdvertsBoard',
                    'repositoryName' => 'App\Repository\ImageRepository',
                    'modelName' => 'App\Models\Image',
                    'imageId' => 27,
                    'relationColumn' => 'itemId',
                    'relationType' => 'Framework\Service\OneToManyRelation'
                ],
                'Advert' => [
                    'databaseName' => 'Dev\trash\MySQLAdvertsBoard',
                    'repositoryName' => 'App\Repository\AdvertRepository',
                    'modelName' => 'App\Models\Advert',
                    'advertId' => 1,
                    'relationColumn' => 'id',
                    'relationType' => 'Framework\Service\ManyToOneRelation'
                ],
            ];
    }

    /**
     * @dataProvider toTestGetRepositoryDataProvider
     */
    public function testGetRelation($databaseName, $repositoryName, $modelName, $imageId, $relationColumn, $relationType)
    {
        $databaseConnection = $databaseName::getInstance();
        $this->assertInstanceOf($databaseName, $databaseConnection);

        $repository = new $repositoryName($databaseConnection);
        $this->assertInstanceOf($repositoryName, $repository);

        [$model] = $repository->findById($imageId);
        $this->assertInstanceOf($modelName, $model);

        $relation = new Relation($model);
        $this->assertInstanceOf(Relation::class, $relation);

        $result = $relation->getRelation($relationColumn);
        $model = (array)$result;
        foreach ($model as $property) {
            if ($property instanceof $relationType) {
                $this->assertObjectHasProperty('relationModels', $property, "AssertFail: Object $relationType has no property 'relationModels'");
                $this->assertNotNull($property->relationModels, "AssertFail: Property model has a NULL VALUE");
            }
        }
//        dd($result);
    }

}
