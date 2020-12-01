/*
* COMP15 Homework 04 , Summer 2020
* word. cpp
* By : William Huang
* Completed : August 6, 2020
*
* Word Class Implementation
* Purpose : This class functions as a container object that contains the word
*           itself, the index of the file directory, the index of the line,
*           and the line number in which the word appears.
*/
#include "word.h"


//constructor
Word::Word(std::string word, int directory_in, int line_in, 
    int line_number){
      
  orig_word = word;
  directory_index = directory_in;
  line_index = line_in;
  line_num = line_number;

}; 

//destructor
Word::~Word(){};

//Getters
std::string Word::getWord() const{
  return orig_word;
};
int Word::getDirectory() const{
  return directory_index;
};
int Word::getLine() const{
  return line_index;
};
int Word::getLineNum() const{
  return line_num;
};

