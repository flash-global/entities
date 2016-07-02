<?php


    namespace Tests\Fei\Entity;

    use Codeception\Test\Unit;
    use Fei\Entity\PaginatedEntitySet;

    class PaginatedEntitySetTest extends Unit
    {
        public function testCurrentPageAccessors()
        {
            $set = new PaginatedEntitySet();

            $set->setCurrentPage(3);

            $this->assertAttributeEquals(3, 'currentPage', $set);
            $this->assertEquals(3, $set->getCurrentPage());
        }
    
        public function testPerPageAccessors()
        {
            $set = new PaginatedEntitySet();
        
            $set->setPerPage(10);
        
            $this->assertAttributeEquals(10, 'perPage', $set);
            $this->assertEquals(10, $set->getPerPage());
        }
    
        public function testTotalAccessors()
        {
            $set = new PaginatedEntitySet();
        
            $set->setTotal(38);
        
            $this->assertAttributeEquals(38, 'total', $set);
            $this->assertEquals(38, $set->getTotal());
        }
    }
