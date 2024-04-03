-- Make sure there is no collection with the same name
db.Agents.drop();
db.Appliances.drop();
db.Companies.drop();
db.Homes.drop();
db.Locations.drop();
db.Owners.drop();
db.SaleHistory.drop();

-- Create Locations
db.createCollection("Locations",{capped:true,size:10000,max:1000})
db.Locations.insert({
    HomeID: "00001",
    LocationID: "1",
    State: "MI",
    City: "Auburn Hills",
    Street: "123 Road",
    Zip: 48326,
    Apt: 111,
});
db.Locations.insert({
    HomeID: "00002",
    LocationID: "2",
    State: "MI",
    City: "Auburn Hills",
    Street: "113 Road",
    Zip: 48326,
    Apt: 222,
});

-- Create Appliances
db.createCollection("Appliances",{capped:true,size:10000,max:1000})
db.Appliances.insertMany([
    {
        ModelName: "XJ2021",
        Year: 2021,
        Maker: "General Electric",
        Name: "Refrigerator",
        Price: 1499.99
    },
    {
        ModelName: "AB1234",
        Year: 2022,
        Maker: "Samsung",
        Name: "Washing Machine",
        Price: 899.99
    },
]);

-- Create Owners
db.createCollection("Owners",{capped:true,size:10000,max:1000})
db.Owners.insertMany([
    {
        OwnerID: "001",
        OwnerName: "Sam",
        SSN: 11122233,
        MemNum: 5,
        Age: 34,
        Profession: "Doctor"
    },
    {
        OwnerID: "002",
        OwnerName: "Alice",
        SSN: 44455566,
        MemNum: 3,
        Age: 40,
        Profession: "Engineer"
    }
]);

-- Create Agents
db.createCollection("Agents",{capped:true,size:10000,max:1000})
db.Agents.insertMany([
  {
    AgentID: "0001",
    AgentName: "Alex",
    Companies: [
      {CompanyName: "Company A"},
      {CompanyName: "Company B"}
    ]
  },
  {
    AgentID: "0002",
    AgentName: "Mina",
    Companies: [
      {CompanyName: "Company A"}
    ]
  }
]);

-- Create Companies
db.createCollection("Companies",{capped:true,size:10000,max:1000})
db.Companies.insertMany([
    {
        CompanyName: "Company A",
        Rate: 0.3,
        Agents:[
          {AgentID: "0001"},
          {AgentID: "0002"},
        ]
    },
    {
        CompanyName: "Company B",
        Rate: 0.25,
        Agents:[
          {AgentID: "0001"}
        ]
    },
]);

-- Create Homes
db.createCollection("Homes",{capped:true,size:10000,max:1000})
db.Homes.insertMany ([
  {
    HomeID: "00001",
    FloorSpace: 320,
    Floors: 2,
    BedRooms: 4,
    BathRooms: 3,
    LandSize: 1200,
    YearConstructed: 2022,
    Type: "mansion",
    Appliances: [
      { ModelName: "XJ2021" },
      { ModelName: "AB1234" }
    ],
    OwnerID: "001",
    LocationId: "1",
    AgentId: "001",
    CompanyName: "Company A",
    Price: 1000000,
    Status: "On Sale"
  },
  {
    HomeID: "00002",
    FloorSpace: 120,
    Floors: 5,
    BedRooms: 4,
    BathRooms:3,
    LandSize: 1200,
    YearConstructed: 2020,
    Type: "apartment",
    Appliances: [
      { ModelName: "XJ2021" }
    ],
    OwnerID: "002",
    LocationId: "2",
    AgentId: "001",
    CompanyName: "Company A",
    Price: 280000,
    Status: "On Sale"
  }
]);

-- Create SaleHistory
-- BuyerID is OwnerID
db.createCollection("SaleHistory",{capped:true,size:10000,max:1000})
db.SaleHistory.({
  HomeID: "00001",insertOne
  AgentID:  "0001",
  BuyerID: "001",
  CompanyName: "Company A",
  Price: 340000
});
db.SaleHistory.insertOne({
  HomeID: "00001",
  AgentID:  "0001",
  BuyerID: "001",
  CompanyName: "Company B",
  Price: 300000
});
db.SaleHistory.insertOne({
  HomeID: "00002",
  AgentID:  "0002",
  BuyerID: "001",
  CompanyName: "Company B",
  Price: 250000
});
db.SaleHistory.insertOne({
  HomeID: "00002",
  AgentID:  "0002",
  BuyerID: "002",
  CompanyName: "Company B",
  Price: 270000
});


-- Q1
db.Homes.aggregate([
  {
    $lookup: {
      from: "Locations",
      localField: "LocationId",
      foreignField: "LocationID",
      as: "LocationInfo"
    }
  },
  {
    $lookup: {
      from: "Owners",
      localField: "OwnerID",
      foreignField: "OwnerID",
      as: "OwnerInfo"
    }
  },
  {
    $match: {
      "LocationInfo.City": "Auburn Hills", 
      "OwnerInfo.OwnerName": "Alice" 
    }
  }
])

-- Q2
db.SaleHistory.aggregate([
  {
    $group: {
      _id: "$HomeID",
      count: { $sum: 1 }
    }
  },
  {
    $match: {
      count: { $gt: 1 }
    }
  }
])

-- Q3
db.SaleHistory.aggregate([
  {
    $group: {
      _id: "$BuyerID",
      maxPrice: { $max: "$Price" }
    }
  },
  {
    $lookup: {
      from: "Homes",
      localField: "maxPrice",
      foreignField: "Price",
      as: "ExpensiveHome"
    }
  },
  {
    $project: {
      OwnerID: "$_id",
      ExpensiveHomeID: { $arrayElemAt: ["$ExpensiveHome.HomeID", 0] },
      Price: "$maxPrice"
    }
  }
])

-- Q4
db.homes.aggregate([
  {
    $lookup: {
      from: "appliances",
      localField: "appliances.ModelName",
      foreignField: "ModelName",
      as: "ApplianceDetails"
    }
  },
  {
    $unwind: "$ApplianceDetails"
  },
  {
    $match: {
      "ApplianceDetails.Maker": "Samsung"
    }
  },
  {
    $project: {
      "ApplianceDetails.ModelName": 1,
      "ApplianceDetails.Year": 1,
      "ApplianceDetails.Maker": 1,
      "ApplianceDetails.Name": 1,
      "ApplianceDetails.Price": 1,
      _id: 0
    }
  }
])

-- Q5
db.SaleHistory.aggregate([
  { $group: {
    _id: "$BuyerID",
    homes: { $addToSet: "$HomeID" }
  }},
  { $lookup: {
    from: "Homes",
    localField: "_id",
    foreignField: "OwnerID",
    as: "currentHomes"
  }},
  { $project: {
    _id: 1,
    homes: 1,
    currentHomes: { $map: {
      input: "$currentHomes",
      as: "home",
      in: "$$home.HomeID"
    }}
  }},
  { $match: {
    $expr: {
      $not: { $setIsSubset: ["$homes", "$currentHomes"] }
    }
  }},
  { $lookup: {
    from: "Owners",
    localField: "_id",
    foreignField: "OwnerID",
    as: "owner"
  }},
  { $unwind: "$owner" },
  { $project: { _id: 0, owner: 1 } }
])

-- Q6
db.SaleHistory.aggregate([
  { $match: { AgentID: "0001" } }, 
  { $lookup: {
    from: "Companies",
    localField: "CompanyName",
    foreignField: "CompanyName",
    as: "company"
  }},
  { $unwind: "$company" },
  { $group: {
    _id: "$AgentID",
    totalCommission: {
      $sum: {
        $multiply: ["$Price", "$company.Rate"]
      }
    }
  }}
]);


-- Q7
db.Homes.aggregate([
  { $group: {
    _id: "$OwnerID",
    types: { $addToSet: "$Type" }
  }},
  { $match: {
    types: { $all: ["apartment", "mansion"] }
  }},
  { $lookup: {
    from: "Owners",
    localField: "_id",
    foreignField: "OwnerID",
    as: "owner"
  }},
  { $unwind: "$owner" },
  { $project: { _id: 0, owner: 1 } }
])

-- Q8
db.Homes.aggregate([
  {
    $lookup: {
      from: "Locations",
      localField: "LocationId",
      foreignField: "LocationID",
      as: "location"
    }
  },
  { $unwind: "$location" },
  {
    $match: {
      "location.City": "Auburn Hills", 
      Price: { $lt: 500000 }
    }
  },
  {
    $project: {
      _id: 0,
      HomeID: 1,
      Price: 1,
      City: "$location.City"
    }
  }
])

-- Q9
db.Homes.aggregate([
  {
    $lookup: {
      from: "Locations",
      localField: "LocationId",
      foreignField: "LocationID",
      as: "location"
    }
  },
  { $unwind: "$location" },
  {
    $match: {
      "location.City": "Auburn Hills"
    }
  },
  {
    $group: {
      _id: null,
      maxPrice: { $max: "$Price" },
      expensiveHomes: {
        $push: {
          HomeID: "$HomeID",
          Price: "$Price",
          OwnerID: "$OwnerID"
        }
      }
    }
  },
  {
    $project: {
      _id: 0,
      expensiveHomes: {
        $filter: {
          input: "$expensiveHomes",
          as: "home",
          cond: { $eq: ["$$home.Price", "$maxPrice"] }
        }
      }
    }
  },
  { $unwind: "$expensiveHomes" },
  {
    $group: {
      _id: "$expensiveHomes.OwnerID"
    }
  },
  {
    $lookup: {
      from: "Owners",
      localField: "_id",
      foreignField: "OwnerID",
      as: "owner"
    }
  },
  { $unwind: "$owner" },
  {
    $project: {
      _id: 0,
      OwnerID: "$owner.OwnerID",
      OwnerName: "$owner.OwnerName"
    }
  }
])

-- Q10
db.Homes.aggregate([
  {
    $lookup: {
      from: "Locations",
      localField: "LocationId",
      foreignField: "LocationID",
      as: "location"
    }
  },
  { $unwind: "$location" },
  {
    $match: {
      "location.City": "Auburn Hills",
      Status: "On Sale", 
      BedRooms: 4, 
      BathRooms: 3 
    }
  },
  {
    $project: {
      _id: 0,
      HomeID: 1,
      FloorSpace: 1,
      Price: 1,
      BedRooms: 1,
      BathRooms: 1,
      City: "$location.City"
    }
  }
])