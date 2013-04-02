draft-db
========

A simple NoSQL PHP Class that mimics some of the behaviour of large NoSQL databases. It was created to help people learn and experiment with NoSQL without having to invest or setup a large NoSQL server.


**PUBLIC FUNCTIONS**
- get($key);                                            
- set($key, $value, $encryption_flag);   
- append($key, $value);                
- touch($key);                                       
- unlink($key);                                      

**EXTENDED DESCRIPTION**

When I created my blog, I needed a simple mechanism to store information. It had to be small, flexible, and have a small footprint. As I didn't want to invest in a large DB Server (Couchbase, MongoDB, etc) I decided to create my own PHP layer just for this purpose.

**CURRENT PURPOSE**
- Give developers unfamiliar with NoSQL a quick and fun way to get started
- Quickly develop NoSQL applications without the overhead of a DB Server


**Future TODO:**
- Create a NodeJS version
- Expand functionality
