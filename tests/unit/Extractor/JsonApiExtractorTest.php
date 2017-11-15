<?php

namespace Tests\Fei\Extractor;

use Fei\Entity\AbstractEntity;
use Fei\Entity\EntitySet;
use Fei\Entity\Extractor\JsonApiExtractException;
use Fei\Entity\Extractor\JsonApiExtractor;
use Fei\Entity\PaginatedEntitySet;
use PHPUnit\Framework\TestCase;

/**
 * Class JsonApiExtractorTest
 *
 * @package Tests\Fei\Service\Address\Entity
 */
class JsonApiExtractorTest extends TestCase
{

    /**
     * @dataProvider dataForTestExtract
     *
     * @param mixed           $input
     * @param mixed           $expected
     * @param \Exception|null $triggerException
     */
    public function testExtract($input, $expected, \Exception $triggerException = null)
    {

        if ($triggerException) {
            $this->expectException(get_class($triggerException));
            $this->expectExceptionMessage($triggerException->getMessage());
        }

        $result = (new JsonApiExtractor)->extract($input);

        $this->assertEquals($expected, $result);
    }

    public function dataForTestExtract()
    {
        return [
            [
                json_decode(<<<JSON
{
    "data": {
        "type": "Tests\\\Fei\\\Extractor\\\Sna",
        "id": "1",
        "attributes": {
            "line1": "",
            "line2": "",
            "line3": "",
            "line4": "3 Avenue Robert Schuman",
            "line5": "",
            "line6": "57000 Metz",
            "line7": "FR"
        },
        "relationships": {
            "address": {
                "data": {
                    "type": "Tests\\\Fei\\\Extractor\\\Address",
                    "id": "1"
                }
            }
        }
        
    },
    "included": [
        {
            "type": "Tests\\\Fei\\\Extractor\\\Address",
            "id": "1",
            "attributes": {
                "recipient": null,
                "reference": null,
                "createdAt": "2017-11-03T12:03:30+0100",
                "label": "Test1",
                "address": "3 Avenue Robert Schuman",
                "addressGeoprovided": "3 Avenue Robert Schuman",
                "additionnalAddress": null,
                "zip": "57000",
                "city": "Metz",
                "cedex": null,
                "country": "FR",
                "timezone": "Europe/Paris",
                "longitude": 6.1728442,
                "latitude": 49.115068,
                "geoprovider": "Google Maps",
                "isDeleted": false
            }
        }
    ]
}
JSON
                , true
                ),
                (new Sna())
                    ->setAddress(
                        (new Address())
                            ->setId(1)
                            ->setCreatedAt(new \DateTime('2017-11-03T12:03:30+0100'))
                            ->setLabel('Test1')
                            ->setAddress('3 Avenue Robert Schuman')
                            ->setAddressGeoprovided('3 Avenue Robert Schuman')
                            ->setZip('57000')
                            ->setCity('Metz')
                            ->setCountry('FR')
                            ->setTimezone('Europe/Paris')
                            ->setLongitude('6.1728442')
                            ->setLatitude('49.115068')
                            ->setGeoprovider('Google Maps')
                    )
            ],
            [
                json_decode(<<<JSON
{
    "data": [
        {
            "type": "Tests\\\Fei\\\Extractor\\\Sna",
            "id": "1",
            "attributes": {
                "line1": "",
                "line2": "",
                "line3": "",
                "line4": "3 Avenue Robert Schuman",
                "line5": "",
                "line6": "57000 Metz",
                "line7": "FR"
            },
            "relationships": {
                "address": {
                    "data": {
                        "type": "Tests\\\Fei\\\Extractor\\\Address",
                        "id": "1"
                    }
                }
            }
        },
        {
            "type": "Tests\\\Fei\\\Extractor\\\Sna",
            "id": "10",
            "attributes": {
                "line1": "Mr. Robot",
                "line2": "",
                "line3": "",
                "line4": "Updated address1509711856#single",
                "line5": "",
                "line6": "57070 Metz",
                "line7": "FR"
            },
            "relationships": {
                "address": {
                    "data": {
                        "type": "Tests\\\Fei\\\Extractor\\\Address",
                        "id": "10"
                    }
                }
            }
        }
    ],
    "included": [
        {
            "type": "Tests\\\Fei\\\Extractor\\\Address",
            "id": "10",
            "attributes": {
                "recipient": "Mr. Robot",
                "reference": null,
                "createdAt": "2017-11-03T13:24:15+0100",
                "label": "Address name updated1509711856#single",
                "address": "Updated address1509711856#single",
                "addressGeoprovided": null,
                "additionnalAddress": null,
                "zip": "57070",
                "city": "Metz",
                "cedex": null,
                "country": "FR",
                "timezone": "Europe/Paris",
                "longitude": null,
                "latitude": null,
                "geoprovider": null,
                "isDeleted": false
            }
        },
        {
            "type": "Tests\\\Fei\\\Extractor\\\Address",
            "id": "1",
            "attributes": {
                "recipient": null,
                "reference": null,
                "createdAt": "2017-11-03T12:03:30+0100",
                "label": "Test1",
                "address": "3 Avenue Robert Schuman",
                "addressGeoprovided": "3 Avenue Robert Schuman",
                "additionnalAddress": null,
                "zip": "57000",
                "city": "Metz",
                "cedex": null,
                "country": "FR",
                "timezone": "Europe/Paris",
                "longitude": 6.1728442,
                "latitude": 49.115068,
                "geoprovider": "Google Maps",
                "isDeleted": false
            }
        }
    ],
    "meta": {
        "pagination": {
            "total": 9,
            "count": 9,
            "per_page": 20,
            "current_page": 1,
            "total_pages": 1
        }
    },
    "links": {
        "self": "http://localhost:8082/api/addresses?sna=1&page=1",
        "first": "http://localhost:8082/api/addresses?sna=1&page=1",
        "last": "http://localhost:8082/api/addresses?sna=1&page=1"
    }
}
JSON
                    , true
                ),
                (new PaginatedEntitySet([
                    (new Sna())
                        ->setAddress(
                            (new Address())
                                ->setId(1)
                                ->setCreatedAt(new \DateTime('2017-11-03T12:03:30+0100'))
                                ->setLabel('Test1')
                                ->setAddress('3 Avenue Robert Schuman')
                                ->setAddressGeoprovided('3 Avenue Robert Schuman')
                                ->setZip('57000')
                                ->setCity('Metz')
                                ->setCountry('FR')
                                ->setTimezone('Europe/Paris')
                                ->setLongitude('6.1728442')
                                ->setLatitude('49.115068')
                                ->setGeoprovider('Google Maps')
                        ),
                    (new Sna())
                        ->setAddress(
                            (new Address())
                                ->setId(10)
                                ->setRecipient('Mr. Robot')
                                ->setCreatedAt(new \DateTime('2017-11-03T13:24:15+0100'))
                                ->setLabel('Address name updated1509711856#single')
                                ->setAddress('Updated address1509711856#single')
                                ->setZip('57070')
                                ->setCity('Metz')
                                ->setCountry('FR')
                                ->setTimezone('Europe/Paris')
                        )
                ]))
                    ->setCurrentPage(1)
                    ->setPerPage(20)
                    ->setTotal(9)
            ],
            [
                json_decode(<<<JSON
{
    "data": [
        {
            "type": "Tests\\\Fei\\\Extractor\\\Sna",
            "id": "1",
            "attributes": {
                "line1": "",
                "line2": "",
                "line3": "",
                "line4": "3 Avenue Robert Schuman",
                "line5": "",
                "line6": "57000 Metz",
                "line7": "FR"
            },
            "relationships": {
                "address": {
                    "data": {
                        "type": "Tests\\\Fei\\\Extractor\\\Address",
                        "id": "1"
                    }
                }
            }
        },
        {
            "type": "Tests\\\Fei\\\Extractor\\\Sna",
            "id": "10",
            "attributes": {
                "line1": "Mr. Robot",
                "line2": "",
                "line3": "",
                "line4": "Updated address1509711856#single",
                "line5": "",
                "line6": "57070 Metz",
                "line7": "FR"
            },
            "relationships": {
                "address": {
                    "data": {
                        "type": "Tests\\\Fei\\\Extractor\\\Address",
                        "id": "10"
                    }
                }
            }
        }
    ],
    "included": [
        {
            "type": "Tests\\\Fei\\\Extractor\\\Address",
            "id": "10",
            "attributes": {
                "recipient": "Mr. Robot",
                "reference": null,
                "createdAt": "2017-11-03T13:24:15+0100",
                "label": "Address name updated1509711856#single",
                "address": "Updated address1509711856#single",
                "addressGeoprovided": null,
                "additionnalAddress": null,
                "zip": "57070",
                "city": "Metz",
                "cedex": null,
                "country": "FR",
                "timezone": "Europe/Paris",
                "longitude": null,
                "latitude": null,
                "geoprovider": null,
                "isDeleted": false
            }
        },
        {
            "type": "Tests\\\Fei\\\Extractor\\\Address",
            "id": "1",
            "attributes": {
                "recipient": null,
                "reference": null,
                "createdAt": "2017-11-03T12:03:30+0100",
                "label": "Test1",
                "address": "3 Avenue Robert Schuman",
                "addressGeoprovided": "3 Avenue Robert Schuman",
                "additionnalAddress": null,
                "zip": "57000",
                "city": "Metz",
                "cedex": null,
                "country": "FR",
                "timezone": "Europe/Paris",
                "longitude": 6.1728442,
                "latitude": 49.115068,
                "geoprovider": "Google Maps",
                "isDeleted": false
            }
        }
    ]
}
JSON
                    , true
                ),
                new EntitySet([
                    (new Sna())
                        ->setAddress(
                            (new Address())
                                ->setId(1)
                                ->setCreatedAt(new \DateTime('2017-11-03T12:03:30+0100'))
                                ->setLabel('Test1')
                                ->setAddress('3 Avenue Robert Schuman')
                                ->setAddressGeoprovided('3 Avenue Robert Schuman')
                                ->setZip('57000')
                                ->setCity('Metz')
                                ->setCountry('FR')
                                ->setTimezone('Europe/Paris')
                                ->setLongitude('6.1728442')
                                ->setLatitude('49.115068')
                                ->setGeoprovider('Google Maps')
                        ),
                    (new Sna())
                        ->setAddress(
                            (new Address())
                                ->setId(10)
                                ->setRecipient('Mr. Robot')
                                ->setCreatedAt(new \DateTime('2017-11-03T13:24:15+0100'))
                                ->setLabel('Address name updated1509711856#single')
                                ->setAddress('Updated address1509711856#single')
                                ->setZip('57070')
                                ->setCity('Metz')
                                ->setCountry('FR')
                                ->setTimezone('Europe/Paris')
                        )
                ])
            ],
            [
                json_decode(<<<JSON
{
    "data": [
        {
            "type": "Tests\\\Fei\\\Extractor\\\Sna",
            "id": "1",
            "attributes": {
                "line1": "",
                "line2": "",
                "line3": "",
                "line4": "3 Avenue Robert Schuman",
                "line5": "",
                "line6": "57000 Metz",
                "line7": "FR"
            },
            "relationships": {
                "address": {
                    "data": {
                        "type": "Tests\\\Fei\\\Extractor\\\Address",
                        "id": "1"
                    }
                }
            }
        },
        {
            "type": "Tests\\\Fei\\\Extractor\\\Sna",
            "id": "10",
            "attributes": {
                "line1": "Mr. Robot",
                "line2": "",
                "line3": "",
                "line4": "Updated address1509711856#single",
                "line5": "",
                "line6": "57070 Metz",
                "line7": "FR"
            },
            "relationships": {
                "address": {
                    "data": {
                        "type": "Tests\\\Fei\\\Extractor\\\Address",
                        "id": "10"
                    }
                }
            }
        }
    ],
    "included": [
        {
            "type": "Tests\\\Fei\\\Extractor\\\Address",
            "id": "10",
            "attributes": {
                "recipient": "Mr. Robot",
                "reference": null,
                "createdAt": "2017-11-03T13:24:15+0100",
                "label": "Address name updated1509711856#single",
                "address": "Updated address1509711856#single",
                "addressGeoprovided": null,
                "additionnalAddress": null,
                "zip": "57070",
                "city": "Metz",
                "cedex": null,
                "country": "FR",
                "timezone": "Europe/Paris",
                "longitude": null,
                "latitude": null,
                "geoprovider": null,
                "isDeleted": false
            }
        },
        {
            "type": "Tests\\\Fei\\\Extractor\\\Address",
            "id": "1",
            "attributes": {
                "recipient": null,
                "reference": null,
                "createdAt": "2017-11-03T12:03:30+0100",
                "label": "Test1",
                "address": "3 Avenue Robert Schuman",
                "addressGeoprovided": "3 Avenue Robert Schuman",
                "additionnalAddress": null,
                "zip": "57000",
                "city": "Metz",
                "cedex": null,
                "country": "FR",
                "timezone": "Europe/Paris",
                "longitude": 6.1728442,
                "latitude": 49.115068,
                "geoprovider": "Google Maps",
                "isDeleted": false
            }
        }
    ],
    "meta": {
        "pagination": {
            "per_page": 20,
            "current_page": 1,
            "total_pages": 1
        }
    },
    "links": {
        "self": "http://localhost:8082/api/addresses?sna=1&page=1",
        "first": "http://localhost:8082/api/addresses?sna=1&page=1",
        "last": "http://localhost:8082/api/addresses?sna=1&page=1"
    }
}
JSON
                    , true
                ),
                new EntitySet([
                    (new Sna())
                        ->setAddress(
                            (new Address())
                                ->setId(1)
                                ->setCreatedAt(new \DateTime('2017-11-03T12:03:30+0100'))
                                ->setLabel('Test1')
                                ->setAddress('3 Avenue Robert Schuman')
                                ->setAddressGeoprovided('3 Avenue Robert Schuman')
                                ->setZip('57000')
                                ->setCity('Metz')
                                ->setCountry('FR')
                                ->setTimezone('Europe/Paris')
                                ->setLongitude('6.1728442')
                                ->setLatitude('49.115068')
                                ->setGeoprovider('Google Maps')
                        ),
                    (new Sna())
                        ->setAddress(
                            (new Address())
                                ->setId(10)
                                ->setRecipient('Mr. Robot')
                                ->setCreatedAt(new \DateTime('2017-11-03T13:24:15+0100'))
                                ->setLabel('Address name updated1509711856#single')
                                ->setAddress('Updated address1509711856#single')
                                ->setZip('57070')
                                ->setCity('Metz')
                                ->setCountry('FR')
                                ->setTimezone('Europe/Paris')
                        )
                ])
            ],
            [
                json_decode(<<<JSON
{
    "data": {
        "type": "Tests\\\Fei\\\Extractor\\\Address",
        "id": "1",
        "attributes": {
            "recipient": null,
            "reference": null,
            "createdAt": "2017-11-03T12:03:30+0100",
            "label": "Test1",
            "address": "3 Avenue Robert Schuman",
            "addressGeoprovided": "3 Avenue Robert Schuman",
            "additionnalAddress": null,
            "zip": "57000",
            "city": "Metz",
            "cedex": null,
            "country": "FR",
            "timezone": "Europe/Paris",
            "longitude": 6.1728442,
            "latitude": 49.115068,
            "geoprovider": "Google Maps",
            "isDeleted": false
        },
        "relationships": {
            
        }
    }
}
JSON
                    , true
                ),
                (new Address())
                    ->setId(1)
                    ->setCreatedAt(new \DateTime('2017-11-03T12:03:30+0100'))
                    ->setLabel('Test1')
                    ->setAddress('3 Avenue Robert Schuman')
                    ->setAddressGeoprovided('3 Avenue Robert Schuman')
                    ->setZip('57000')
                    ->setCity('Metz')
                    ->setCountry('FR')
                    ->setTimezone('Europe/Paris')
                    ->setLongitude('6.1728442')
                    ->setLatitude('49.115068')
                    ->setGeoprovider('Google Maps')
            ],
            [
                json_decode(<<<JSON
{
    "data": {
        "type": "Tests\\\Fei\\\Extractor\\\Address",
        "id": "1",
        "attributes": {
            "recipient": null,
            "reference": null,
            "createdAt": "2017-11-03T12:03:30+0100",
            "label": "Test1",
            "address": "3 Avenue Robert Schuman",
            "addressGeoprovided": "3 Avenue Robert Schuman",
            "additionnalAddress": null,
            "zip": "57000",
            "city": "Metz",
            "cedex": null,
            "country": "FR",
            "timezone": "Europe/Paris",
            "longitude": 6.1728442,
            "latitude": 49.115068,
            "geoprovider": "Google Maps",
            "isDeleted": false
        },
        "relationships": {
        }
    },
    "included": []
}
JSON
                    , true
                ),
                (new Address())
                    ->setId(1)
                    ->setCreatedAt(new \DateTime('2017-11-03T12:03:30+0100'))
                    ->setLabel('Test1')
                    ->setAddress('3 Avenue Robert Schuman')
                    ->setAddressGeoprovided('3 Avenue Robert Schuman')
                    ->setZip('57000')
                    ->setCity('Metz')
                    ->setCountry('FR')
                    ->setTimezone('Europe/Paris')
                    ->setLongitude('6.1728442')
                    ->setLatitude('49.115068')
                    ->setGeoprovider('Google Maps')
            ],
            [
                json_decode(<<<JSON
{
    "data": {
        "type": "Tests\\\Fei\\\Extractor\\\Address",
        "id": "1",
        "attributes": {
            "recipient": null,
            "reference": null,
            "createdAt": "2017-11-03T12:03:30+0100",
            "label": "Test1",
            "address": "3 Avenue Robert Schuman",
            "addressGeoprovided": "3 Avenue Robert Schuman",
            "additionnalAddress": null,
            "zip": "57000",
            "city": "Metz",
            "cedex": null,
            "country": "FR",
            "timezone": "Europe/Paris",
            "longitude": 6.1728442,
            "latitude": 49.115068,
            "geoprovider": "Google Maps",
            "isDeleted": false
        },
        "relationships": {
            
        }
    },
    "included": [
    ]
}
JSON
                    , true
                ),
                (new Address())
                    ->setId(1)
                    ->setCreatedAt(new \DateTime('2017-11-03T12:03:30+0100'))
                    ->setLabel('Test1')
                    ->setAddress('3 Avenue Robert Schuman')
                    ->setAddressGeoprovided('3 Avenue Robert Schuman')
                    ->setZip('57000')
                    ->setCity('Metz')
                    ->setCountry('FR')
                    ->setTimezone('Europe/Paris')
                    ->setLongitude('6.1728442')
                    ->setLatitude('49.115068')
                    ->setGeoprovider('Google Maps')
            ],
            [
                json_decode(<<<JSON
{
    "data": {
        "id": "1",
        "attributes": {
            "recipient": null,
            "reference": null,
            "createdAt": "2017-11-03T12:03:30+0100",
            "label": "Test1",
            "address": "3 Avenue Robert Schuman",
            "addressGeoprovided": "3 Avenue Robert Schuman",
            "additionnalAddress": null,
            "zip": "57000",
            "city": "Metz",
            "cedex": null,
            "country": "FR",
            "timezone": "Europe/Paris",
            "longitude": 6.1728442,
            "latitude": 49.115068,
            "geoprovider": "Google Maps",
            "isDeleted": false
        }
    }
}
JSON
                    , true
                ),
                null,
                new JsonApiExtractException('No data type provided')
            ],
            [
                [], null
            ],
            [
                json_decode(<<<JSON
{
    "data": {
        "type": "alias",
        "id": "1",
        "attributes": {
            "alias": "test"
        }
    }
}
JSON
                    , true
                ),
                [
                    'id' => 1,
                    'alias' => 'test'
                ]
            ]
        ];
    }
}


class Sna extends AbstractEntity
{
    protected $line1;
    protected $line2;
    protected $line3;
    protected $line4;
    protected $line5;
    protected $line6;
    protected $line7;
    protected $address;

    public function getLine1()
    {
        return $this->line1;
    }
    protected function setLine1($line1)
    {
        $this->line1 = $line1;
        return $this;
    }
    public function getLine2()
    {
        return $this->line2;
    }
    protected function setLine2($line2)
    {
        $this->line2 = $line2;
        return $this;
    }
    public function getLine3()
    {
        return $this->line3;
    }
    protected function setLine3($line3)
    {
        $this->line3 = $line3;
        return $this;
    }
    public function getLine4()
    {
        return $this->line4;
    }
    protected function setLine4($line4)
    {
        $this->line4 = $line4;
        return $this;
    }
    public function getLine5()
    {
        return $this->line5;
    }
    protected function setLine5($line5)
    {
        $this->line5 = $line5;
        return $this;
    }
    public function getLine6()
    {
        return $this->line6;
    }
    protected function setLine6($line6)
    {
        $this->line6 = $line6;
        return $this;
    }
    public function getLine7()
    {
        return $this->line7;
    }
    protected function setLine7($line7)
    {
        $this->line7 = $line7;
        return $this;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function setAddress(Address $address)
    {
        $this->address = $address;
        /** @var Address $address */
        $this->setLine1((string) $address->getRecipient());
        $this->setLine2('');
        $this->setLine3((string) !is_null($address->getAdditionnalAddress()) ? $address->getAdditionnalAddress() : '');
        $this->setLine4((string) $address->isGeoprovided() ? $address->getAddressGeoprovided() : $address->getAddress());
        $this->setLine5('');
        $this->setLine6((string) $address->hasCedex() ? $address->getCedex() : $address->getZip().' '.$address->getCity());
        $this->setLine7((string) $address->getCountry());
        return $this;
    }
    public function getId()
    {
        if ($this->getAddress() instanceof Address) {
            return $this->getAddress()->getId();
        }
        return null;
    }
}

class Address extends AbstractEntity
{
    protected $id;
    protected $recipient;
    protected $reference;
    protected $createdAt;
    protected $label;
    protected $address;
    protected $addressGeoprovided;
    protected $additionnalAddress;
    protected $zip;
    protected $city;
    protected $cedex;
    protected $country;
    protected $timezone;
    protected $longitude;
    protected $latitude;
    protected $geoprovider;
    protected $isDeleted = false;
    protected static $geoproviders = [
        'Google Maps',
        'PTV 2015',
        'PTV 2016'
    ];

    public function __construct($data = null)
    {
        $this->setCreatedAt(new \DateTime());
        parent::__construct($data);
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getRecipient()
    {
        return $this->recipient;
    }
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
        return $this;
    }
    public function getReference()
    {
        return $this->reference;
    }
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function setCreatedAt($createdAt)
    {
        if (!$createdAt instanceof \DateTime && is_string($createdAt)) {
            $createdAt = new \DateTime($createdAt);
        }
        $this->createdAt = $createdAt;
        return $this;
    }
    public function getLabel()
    {
        return $this->label;
    }
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }
    public function getAdditionnalAddress()
    {
        return $this->additionnalAddress;
    }
    public function setAdditionnalAddress($additionnalAddress)
    {
        $this->additionnalAddress = $additionnalAddress;
        return $this;
    }
    public function getZip()
    {
        return $this->zip;
    }
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }
    public function getCountry()
    {
        return $this->country;
    }
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }
    public function getTimezone()
    {
        return $this->timezone;
    }
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
        return $this;
    }
    public function getLongitude()
    {
        return $this->longitude;
    }
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }
    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }
    public function getGeoprovider()
    {
        return $this->geoprovider;
    }
    public function setGeoprovider($geoprovider)
    {
        $this->geoprovider = $geoprovider;
        return $this;
    }
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }
    public function getAddressGeoprovided()
    {
        return $this->addressGeoprovided;
    }
    public function setAddressGeoprovided($addressGeoprovided)
    {
        $this->addressGeoprovided = $addressGeoprovided;
        return $this;
    }
    public function getCedex()
    {
        return $this->cedex;
    }
    public function setCedex($cedex)
    {
        $this->cedex = $cedex;
        return $this;
    }
    public function isGeoprovided()
    {
        return !empty($this->addressGeoprovided);
    }

    public function hasCedex()
    {
        return !empty($this->getCedex());
    }
}