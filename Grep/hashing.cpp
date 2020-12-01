/*
  hashing.cpp
  matt russell
  An example from class using std::hash
*/

#include <iostream>
#include <string>
#include <fstream>
#include <vector>
#include <stdlib.h>

int example_hash(std::string input){
  int result = std::hash<std::string>{}(input);
  return abs(result % 100000);
}

int main(){
 
  std::ifstream infile("/comp/15/support/lib/word_list_100000.txt");
  std::string   line;  
  int num_times_hashed[10000] = {0};
  int max_hash_value = 0;  

  if (infile.is_open()){
    while( getline(infile, line) ){      
      num_times_hashed[example_hash(line)]++;
    }    
    infile.close();
  }

  for (int i = 0; i < 100000; i++){
    if (num_times_hashed[i] != 0)
      std::cout << num_times_hashed[i] << std::endl;
  }

  return 0;
}

