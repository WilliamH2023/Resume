/*
* COMP15 Homework 04 , Summer 2020
* word. h
* By : William Huang
* Completed : August 6, 2020
*
* Word Class Interface
* Purpose : This class functions as a container object that contains the word
*           itself, the index of the file directory, the index of the line,
*           and the line number in which the word appears.
*/



#ifndef WORD_H
#define WORD_H
#include<iostream>
#include<sstream>
#include<string.h>


class Word{
  public:
    //constructor
    Word(std::string word, int directory_in, int line_in, 
        int line_number);  
    //destructor
    ~Word();
    
    //Getters
    std::string getWord() const;
    int getDirectory() const;
    int getLine() const;
    int getLineNum() const;

  
  private:
    std::string orig_word;
    int directory_index;
    int line_index;
    int line_num;
  
};
#endif